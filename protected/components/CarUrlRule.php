<?php
/*
* Custom URL rule for Make/Model.
* installed by config/main.php rules and should be first in list
*/

class CarUrlRule extends CBaseUrlRule
{
    /*
    * Build a URL with Make, Model
    */
    
    public function createUrl($manager,$route,$params,$ampersand)
    {
        if($route==='/')	// not sure what to set the route too...
        {
            if (isset($params['make'], $params['model']))
                return $params['make'] . '/' . $params['model'];
            else if (isset($params['make']))
                return $params['make'];
        }
        return false;  // this rule does not apply
    }
 
    public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
    {
		//
		// %^(?|([\w\-\x80-\xff]+)|([\w\-\x80-\xff]+\s[\w\-\x80-\xff]+))(/(?|([\w!\-\x80-\xff]+)|([\w\-\x80-\xff]+\s[\w\-\x80-\xff]+)|([\w\-\x80-\xff]+\s[\w\-\x80-\xff]+\s[\w\-\x80-\xff]+)))?$%
		//
		// Extended case where the character class of [\w\-\x80-\xff] will match ascii words (see pcre/preg-match docs) and the 
		// Odd case for the VW 'Up!' is handled by [\w!\-\x80-\xff] as well as the DASH '-' character which is escaped as well
		// 
		// The \x80-\xff hex in the character class allow the accented characters to be accepted. It's a hack...
		// The DASH '\-' is allowed and will be stripped from the URL if used
		//
		// This will match things like
		// \ford
		// \ford\fiesta 
		// \aston martin\db9 
		// \citroen\Grand C4 Picasso
		// \jeep\grand cherokee
		// \volkswagen\up! (note the `!` is not a word character so handled with special case [A-Za-z0-9!]) 
		// \bmw\series-1 is accepted and the '-' is replaced with a ' ' space.  
		// \bmw\series 1 is the same result as above
		// 
		// Note the Make has only a 1 or 2 word scan and the Model has a 1 to 3 word scan 
		// Might be a better way to do this but that is left as an exercise for the reader...
		
        if(preg_match('%^(?|([\w\-\x80-\xff]+)|([\w\-\x80-\xff]+\s[\w\-\x80-\xff]+))(/(?|([\w!\-\x80-\xff]+)|([\w\-\x80-\xff]+\s[\w\-\x80-\xff]+)|([\w\-\x80-\xff]+\s[\w\-\x80-\xff]+\s[\w\-\x80-\xff]+)))?$%', $pathInfo, $matches))	// /make/model
        {
            // check $matches[1] and $matches[3] to see
            // if they match a manufacturer and a model in the database
            // If so, set $_GET['manufacturer'] and/or $_GET['model']
			//
			// match for offset 1 is MAKE
			// match for offset 3 is Model
			// 
			// Current rule is valid MAKE must be defined or valid MAKE and MODEL

			if(isset($matches[1]))
			{
				
				$matches[1] = str_replace('-',' ', $matches[1]);	// replace dash with space
				$sql = Yii::app()->db->createCommand();
				$sql->select('fab_id, fab_bez');
				$sql->from('{{fabrikate}}'); //and fab_status=0
				$sql->where('fab_bez=:make_name and fab_status=0', array(':make_name' => $matches[1]));
				$rec = $sql->queryRow();	 // false if nothing set, row record otherwise
				
				if(!$rec)
					return false;

				$_GET['make'] = $rec['fab_id']; 		// set to post params
				$_GET['make_name'] = $rec['fab_bez'];		// hack to pass text name
					
				if(isset($matches[3]))
				{
					$matches[3] = str_replace('-',' ', $matches[3]);	// replace dash with space
					$sql = Yii::app()->db->createCommand();
					$sql->select('mod_id, mod_bez');
					$sql->from('{{modelle}}');
					$sql->where('mod_bez=:model_name and mod_status=0', array(':model_name' => $matches[3]));
					$rec1 = $sql->queryRow();	 // false if nothing set, row record otherwise
				
					// if we matched on model too...
					
					if($rec1)
					{
						$_GET['model'] = $rec1['mod_id'];
						$_GET['model_name'] = $rec1['mod_bez'];	// hack to pass text name
						return '/';
					}
				}
				
				if($rec)			// well if we have a make we are still valid
					return '/';
			}
        }
        
        return false;  // this rule does not apply
    }
}//class

?>
