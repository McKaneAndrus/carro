<?php

class SiteController extends Controller
{
	// Until these come from a language file...
	
	public $LANG_MAKE_PROMPT = 'Select a Make';
	public $LANG_MODEL_PROMPT = 'Select a Model';
	public $LANG_TRIM_PROMPT = 'Select a Trim';
	public $LANG_COLOR_PROMPT = 'Select a Color';
	public $LANG_ANY_TRIM_PROMPT = 'Any Trim';
	public $LANG_ANY_COLOR_PROMPT = 'Any Color';
	public $LANG_UNKNOWN_CITY = 'Unknown City';
	public $LANG_UNKNOWN_STATE = 'Unknown State';
	public $LANG_UNKNOWN_MAKE = 'Unknown Make';
	public $LANG_UNKNOWN_MODEL = 'Unknown Model';
	public $LANG_UNKNOWN_TRIM = 'Unknown Trim';
	public $LANG_UNKNOWN_COLOR = 'Unknown Color';
	public $LANG_ZIP_SEP = ', ';
	
	public $DEFAULT_NOT_FOUND_CAR_PIC = 'no_pic.png';
	
	public $DEFAULT_ANY_VALUE = -1;		// must be < 0
		
	/**
	* Default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'. We
	* use a single column as that's how we do these pages
	*/
	
	public $layout='//layouts/column1';	// Single layout no columns

	/*
	* Default Page for site should be the landing page not index.php which is not needed
	*/
	
	public $defaultAction = 'landing';	

	public function get_pic($p_id)
	{
		/*
		* The $url_image_path is use for final generation of the web based URL of the image. 
		* This is typically a relative path from webroot or application root. The problem is
		* that PHP's file_exists() does not work for relative paths and a absolute path is needed
		* to make it work. So the paths for URL and for Filesysytem are handled independantly.
		* 
		* $_SERVER['DOCUMENT_ROOT'] is typically something like '/var/www/' or '/var/www/html/ ......'
		*
		* $url_image_path - path prepended to image filename returned to caller
		* $file_check_path - Absolute filesystem path to the file 
		* $p_filename - valid filename of an image, default is set at start of function!
		*
		* RETURNS : Encoded url to the image
		*/

		$url_image_path = '/images/cars/';									// Can empth if you just want filename
		$file_check_path = $_SERVER['DOCUMENT_ROOT'] . '/images/cars/';		// MUST NOT BE RELATIVE PATH
		$p_filename = $this->DEFAULT_NOT_FOUND_CAR_PIC; 					// must always be a valid filename!

		if ($p_id)
		{
			$sql = Yii::app()->db->createCommand();
			$sql->select('aus_modell, aus_body_id, aus_doors');			// vehicle/trim_id
			$sql->from('{{ausstattung}}');								// will prepend country
			$sql->where('aus_id=:trim_id', array(':trim_id' => $p_id));
			$rec = $sql->queryRow();	 // false if nothing set, row record otherwise
						
			if ($rec)
			{
				// -- Get model name
		   
				$sql1 = Yii::app()->db->createCommand();
				$sql1->select('mod_path, mod_text, mod_fabrikat');			// vehicle/trim_id
				$sql1->from('{{modelle}}');									// will prepend country
				$sql1->where('mod_id=:model_id', array(':model_id' => $rec['aus_modell']));
				$rec1 = $sql1->queryRow();

				if($rec1 == false)
					return $url_image_path . $p_filename;		  		// ugly but safe

				$p_year = intval(substr($rec1['mod_text'], 0, 4));
			   
				// -- If year is unknown, it's impossible to find photos
			   
				if ($p_year >= 1990)
				{
					// -- Get make name
				  
					$sql2 = Yii::app()->db->createCommand();
					$sql2->select('fab_bez');							// vehicle/trim_id
					$sql2->from('{{fabrikate}}');						// will prepend country
					$sql2->where('fab_id=:make_id', array(':make_id' => $rec1['mod_fabrikat']));
					$rec2 = $sql2->queryRow();
				  
					if($rec2 == false)
						return $url_image_path . $p_filename;		  	// ugly but safe
				  
				  
					// build path based on  make, model, year, doors, body type (JATO Specific)
					// file names need no encoding
					
					$p_common_name = strtoupper($rec2['fab_bez']) . '/' . 
						strtoupper($rec1['mod_path']) . '/' . $p_year . '/' . 
						$rec['aus_doors'] . $rec['aus_body_id'];
		
					$p_filename45 = $p_common_name . '_45.JPG';
					$p_filename135 = $p_common_name . '_135.JPG';
					$p_filename0 = $p_common_name . '_0.JPG';
					$p_filename_ = $p_common_name . '.JPG';
					$p_filename135_4 = $p_common_name . '-4_135.JPG';
					$p_filename45_4 = $p_common_name . '-4_45.JPG';
					$p_filename0_4 = $p_common_name. '-4_0.JPG';
					$p_filename_4 = $p_common_name . '-4.JPG';

					// URL needs raw encoding on file names as they sadly contain spaces
					
					$p_common_name = rawurlencode(strtoupper($rec2['fab_bez'])) . '/' . 
						rawurlencode(strtoupper($rec1['mod_path'])) . '/' . $p_year . '/' . 
						$rec['aus_doors'] . $rec['aus_body_id'];

					$p_url45 = $p_common_name . '_45.JPG';
					$p_url135 = $p_common_name . '_135.JPG';
					$p_url0 = $p_common_name . '_0.JPG';
					$p_url_ = $p_common_name . '.JPG';
					$p_url135_4 = $p_common_name . '-4_135.JPG';
					$p_url45_4 = $p_common_name . '-4_45.JPG';
					$p_url0_4 = $p_common_name. '-4_0.JPG';
					$p_url_4 = $p_common_name . '-4.JPG';

					// -- Find photo (hit the file system)
					// keep paths out of filename until the end
					
					if (file_exists($file_check_path . $p_filename45))
						$p_filename = $p_url45;
					else
						if (file_exists($file_check_path . $p_filename135))
							$p_filename = $p_url135;
						else
							if (file_exists($file_check_path . $p_filename0))
								$p_filename = $p_url0;
							else
								if (file_exists($file_check_path . $p_filename_))
									$p_filename = $p_url_;
								else
									if (file_exists($file_check_path . $p_filename45_4))
										$p_filename = $p_url45_4;
									else
										if (file_exists($file_check_path . $p_filename135_4))
											$p_filename = $p_url135_4;
										else
											if (file_exists($file_check_path . $p_filename0_4))
												$p_filename = $p_url0_4;
											else
												if (file_exists($file_check_path . $p_filename_4))
													$p_filename = $p_url_4;
													
												// a fall though here means we wasted a lot of time...
												// we should have the default $p_filename set up with the default
				} // year > 1990
			} // found a modell record
		} // $p_id was specified

		// returns default not found image or one that is valid, with URL path not filesystem!!
		
		return $url_image_path . $p_filename;	
	}

	/*
	* Get the zip to city and state from the zipcode database
	* currently if unknown we return defaults to allow entry to go on, but
	* this may not be the desired behaviour, but it's a start
	*
	* $zip is currently an integer USA style zipcode
	* Returns : ZipLookup 
	*/

	/*
	* Returns a normalized postal code that matches the db format. 
	* keeping simple for now, but could add knowledge of country and each
	* would have the specific case as needed.
	*/
	
	public function NormalizePostalCode($postal_code_str)
	{
		// for the BR postal code we only have the first 5 digits, so we need to make sure we hack off
		// last 3 and replace with 000 as that is what the database has for lookup.
		// format must come in as 00000 or 00000-000 or we return default.
		
		$len = strlen($postal_code_str);
		
		if($len == 5)
			return $postal_code_str . '-000'; // format came in as just the 5 digit
		else
			if($len == 9)
				return substr($postal_code_str, 0, 6) . '000';	// get the '00000-' add suffix
			else
				return '00000-000'; // NULL might be good, not sure yet...
	}

	/*
	* accepts a postal code in the format of 00000-000 
	* this is specific to Brazil. The length of the string must be
	* 5digits'-'3digits digits for a total of 9 characters
	* 
	* returns city and state as well as anything else in the record such
	* as lattitude and longitude if needed. No record found returns the default 
	* city and state of unknown, and all other fields as empty. Might have a better
	* return value indicating success and return the results as a parameter TODO!
	*/
	
	public function GetCityState($postal_code_str)
	{

		// might also check for null or empty here as invalid zip would return that
			
		$postal_code_str = $this->NormalizePostalCode($postal_code_str);	// this is Brazil CEP code specific and must match our data

		$city_state = PostalCodeLookup::model()->find('code=:postal_code', array(':postal_code' => $postal_code_str));

		if($city_state == NULL)
		{
			// create a record and ship it back with some defaults. Log Error as it might be an indication
			// of a missing zipcode and something that could be fixed
			
			$city_state = new PostalCodeLookup();
			$city_state->city = $this->LANG_UNKNOWN_CITY;
			$city_state->state = $this->LANG_UNKNOWN_STATE;
		}

		return $city_state;	// record with City, State, if no match NULL or Empty Array
	}

	/*
	* Get the Make name (string) from a make ID. 
	* currently if unknown we return default
	*
	* $make_id is currently an integer for the make
	* Returns : string name of the make
	*/
	
	public function GetMakeName($make_id)
	{
		$make_rec = MakeLookup::model()->find('fab_id=:id_make', array(':id_make' => $make_id));
		
		if($make_rec == NULL)
			return($this->LANG_UNKNOWN_MAKE);
			
		return($make_rec->fab_bez);
	}
	
	/*
	* Get the Model name (string) from a model ID. 
	* currently if unknown we return default
	*
	* $trim_id is currently an integer for the trim
	* Returns : string name of the model
	*/
		
	public function GetModelName($model_id)
	{
		$model_rec = ModelLookup::model()->find('mod_id=:id_model', array(':id_model' => $model_id));

		if($model_rec == NULL)
			return($this->LANG_UNKNOWN_MODEL);
		
		return($model_rec->mod_bez);
	}

	/*
	* Get the Trim name (string) from a Trim ID. 
	* currently if unknown we return default. Handles
	* the ANY TRIM option
	*
	* $make_id is currently an integer for the make
	* Returns : string name of the trim
	*/
		
	public function GetTrimName($trim_id)
	{
		if($trim_id == $this->DEFAULT_ANY_VALUE)	// our default id for ANY which is not in the database
			return $this->LANG_ANY_TRIM_PROMPT;
		
		$trim_rec = TrimLookup::model()->find('aus_id=:id_trim', array(':id_trim' => $trim_id));

		if($trim_rec == NULL)
			return($this->LANG_UNKNOWN_TRIM);
		
		return($trim_rec->aus_bez);
	}

	/*
	* Get the Color name (string) from a Color ID. 
	* currently if unknown we return default. Handles
	* the ANY COLOR option
	*
	* $color_id is currently an integer for the color
	* Returns : string name of the color
	*/
		
	public function GetColorName($color_id)
	{
		if($color_id == $this->DEFAULT_ANY_VALUE)	// our default id for ANY which is not in the database
			return $this->LANG_ANY_COLOR_PROMPT;
		
		$color_rec = ColorLookup::model()->find('farb_id=:id_color', array(':id_color' => $color_id));

		if($color_rec == NULL)
			return($this->LANG_UNKNOWN_COLOR);
		
		return($color_rec->farb_bez);
	}

	/*
	* Given a Make Id will generate an HTML list data of id, name for use
	* in such places as select fields.
	*
	* Calls the ModelLookup() with the make
	*
	* Returns array of model_id, name for building the html select field
	*/
	
	public function GetModels($make_id)
	{


		$criteria = new CDbCriteria();
		$criteria->select = 'mod_id, mod_bez';	// fields of interest
		$criteria->condition = 'mod_fabrikat=:id_model_make';
		$criteria->order = 'mod_bez';
		$criteria->params = array(':id_model_make' => (int) $make_id);
		$models = ModelLookup::model()->findAll($criteria);

		//$models = ModelLookup::model()->findAll('mod_fabrikat=:id_model_make', array(':id_model_make' => (int) $make_id));

		return CHtml::listData($models, 'mod_id', 'mod_bez');	// fields from the model table
	}


	/*
	* Given a Model Id will generate an HTML list data of id, name for use
	* in such places as select fields.
	*
	* Calls the TrimLookup() with the model
	*
	* Returns array of trim_id, name for building the html select field
	*/
	
	public function GetTrims($model_id)
	{
		// set up query, make easy to read and change
		
		$criteria = new CDbCriteria();
		$criteria->select = 'aus_id, aus_modell, aus_bez, aus_extended_trim';	// fields of interest
		$criteria->condition = 'aus_modell=:id_trim_model';
		$criteria->order = 'aus_extended_trim';
		$criteria->params = array(':id_trim_model' => (int) $model_id);
		$trims = TrimLookup::model()->findAll($criteria);
	
		return CHtml::listData($trims, 'aus_id', 'aus_extended_trim');	// fields from the model table, use unique extended trim
	}

	/*
	* Given a Trim Id will generate an HTML list data of id, name for use
	* in such places as select fields.
	*
	* Calls the ColorLookup() with the trim_id
	*
	* Returns array of color_id, name for building the html select field
	*/

	public function GetColors($trim_id)
	{

		// note that the 'as color' requred a public variable in the model to access
		// the data. Live and learn...
		
		$criteria = new CDbCriteria();
		$criteria->alias = 'mf';
		$criteria->select = 'mf.mf_trim, mf.mf_farbe, s1.farb_bez as color';				// fields of interest (from 2 tables)
		$criteria->join = 'join br_farben s1 on (mf.mf_farbe = s1.farb_id)';
		$criteria->condition = 'mf.mf_trim=:id_color_trim';
		$criteria->params = array(':id_color_trim' => (int) $trim_id);	// related key

		$colors = TrimToColor::model()->findAll($criteria);

		return CHtml::listData($colors, 'mf_farbe', 'color');	// fields color ID and name
	}

	public function GetDealers($postal_code_str, $limit)
	{

		$postal_code_str = $this->NormalizePostalCode($postal_code_str);	// this is Brazil CEP code specific and must match our data
		
		/*
		* // This is the old called that called the dealer lookup model
		* // Replaced with the proc call that calc's distance 
		*
		* $postal_code_str = substr($postal_code_str, 0, 5);				// now we can safely clean to 5 digits
		* 
		* $dealers = DealerLookup::model()->findAll(
		*	array(
		*		'select'=>'hd_id, hd_name, hd_str, hd_ort, hd_plz',			// select only needed fields, this table has lots!
		*		'condition'=>'hd_plz like :postal_code',					// use a like on the codes, cheeeezy but works
		*		'limit'=> $limit,
		*		'params'=>array(':postal_code' => $postal_code_str . '%'),	// tricky way to get the trailing '%' into the like
		*	)
		*);
		*/

		/*
		* Proc returns number max number of results for a given distance of a user from a dealer
		* Indexes may help on some items
		*
		* The algo below basically can call the sp a few times. This proc is expensive so
		* keep loop count low. The idea is to geometrically increase the size of the
		* distance and requery until a suitable amount of dealers are found. If the number
		* of tries is exceeded then you get what was found.
		* 
		* The distance used for the start ($dist) should be chosen accordingly
		*/
		
		
		$q = 'CALL P_br_dealer_distance_km(:user_postal_code, :distance_km, :max_results)';
		$cmd = Yii::app()->db->createCommand($q);
		$dist = 100;	// 100 sq km box for the start, remember ordered by distance
		$cnt = 0;
		do
		{
			$cmd->bindParam(':user_postal_code', $postal_code_str, PDO::PARAM_STR);
			$cmd->bindParam(':distance_km', $dist, PDO::PARAM_INT);
			$cmd->bindParam(':max_results', $limit, PDO::PARAM_INT);
			$dealers = $cmd->queryAll();
			
			if(count($dealers) > $limit)	// we have found minimum # results
				break;
			
			// echo 'Cnt : ' . count($dealers) . ', Dist : ' . $dist . '<br>';
			
			$dist = $dist * 2;		// qeometricly increase the area (its a square size)
			$cnt++;					// bump or you will dead the server
			
		}while($cnt < 4);			// exit on 4th query attempt, getting wasteful now...

		/*
		* The CheckBoxList we want has several lines of text so we must
		* format it here. No <BR> on the last line, and possibly may want
		* to limit lenght of data for each line or increase size of area
		* width
		*/

		return CHtml::listData($dealers, 'hd_id', function($dealers) {
			return CHtml::encode($dealers['hd_name']) . 
			'<br>' . CHtml::encode($dealers['hd_str']) . 
			'<br>' . CHtml::encode($dealers['hd_ort'] . $this->LANG_ZIP_SEP .  $dealers['hd_plz']) .
			'<br>' . CHtml::encode($dealers['hd_tel']).
			'<br>' . CHtml::encode('Distance : ' . $dealers['distance'] . 'km');
		});
	}

	/*
	* Returns makes given a make id (id_make)
	* called based on the select's ajax call. This given a model will return a list of all the trims
	* that are passed back to the select. This is called directly by component to populate a dependent
	* dropdown.
	*
	* It currently has a couple of default values for the prompt and as well for a default to select
	* ANY so a specific trim may not need to be selected but we stuff the option here	
	*/

	public function actionModels() 
	{
		// The post parameters come from the form name, in this case it's LeadGen, with the field value as make
			
		$return = $this->GetModels((int) ($_POST['LeadGen']['int_fabrikat']));

		// if we have results gen the html, always create the default option
		
		echo CHtml::tag('option', array('value' => ""), CHtml::encode($this->LANG_MODEL_PROMPT), true);		// prompt

		// return the html for the SELECT as <option value="xyz">trimname</option>

		foreach ($return as $modelId => $modelName) 
		{
			echo CHtml::tag('option', array('value' => $modelId), CHtml::encode($modelName), true);
		}
	 }

	/*
	* Returns trims given a model id (id_model)
	* called based on the select's ajax call. This given a model will return a list of all the trims
	* that are passed back to the select. This is called directly by component to populate a dependent
	* dropdown.
	*
	* It currently has a couple of default values for the prompt and as well for a default to select
	* ANY so a specific trim may not need to be selected but we stuff the option here	
	*/
	
	public function actionTrims() 
	{
		// The post parameters come from the form name, in this case it's LeadGen, with the field value as model
				
		$trims = GetTrims((int) ($_POST['LeadGen']['int_modell']));	// post has the request model we need trims for

		// stuff the prompt and the default any value
		
		echo CHtml::tag('option', array('value' => ""), CHtml::encode($this->LANG_TRIM_PROMPT), true);			// Prompt
		echo CHtml::tag('option', array('value' => $this->DEFAULT_ANY_VALUE), CHtml::encode($this->LANG_ANY_TRIM_PROMPT), true);		// Any Option

		// return the html for the SELECT as <option value="xyz">trimname</option>
		
		foreach ($return as $trimId => $trimName) 
		{
			echo CHtml::tag('option', array('value' => $trimId), CHtml::encode($trimName), true);
		}
	}

	/*
	* Returns colors given a trim id (id_trim)
	* called based on the select's ajax call. This given a model will return a list of all the trims
	* that are passed back to the select. This is called directly by component to populate a dependent
	* dropdown.
	*
	* It currently has a couple of default values for the prompt and as well for a default to select
	* ANY so a specific color may not need to be selected but we stuff the option here	
	*/

	public function actionColors() 
	{
		// The post parameters come from the form name, in this case it's LeadGen, with the field value as trim

		$return = $this->GetColors((int) ($_POST['LeadGen']['int_ausstattung'])); // when the trim (int_ausstattung) to color relation is valid
		
		// stuff the prompt and the default any value

		echo CHtml::tag('option', array('value' => ""), CHtml::encode($this->LANG_COLOR_PROMPT), true);			// prompt
		echo CHtml::tag('option', array('value' => $this->DEFAULT_ANY_VALUE), CHtml::encode($this->LANG_ANY_COLOR_PROMPT), true);	// Any Option

		// return the html for the SELECT as <option value="xyz">trimname</option>

		foreach ($return as $colorId => $colorName) 
		{
			echo CHtml::tag('option', array('value' => $colorId), CHtml::encode($colorName), true);
		}
	}

	/*
	* Ajax call's to return the image name for 
	*  Make (fabrikate) which return 3 images in an array
	*  Model which returns 1 image
	*  Trim which returns 1 image
	*
	* NOTE NOTE : the rand() order is costly and if too slow, drop this type of sort!!
	*/
	
	public function actionPhotoMakes()
	{
		// check for Ajax call, reject call if not
		
		/*
		if(!YII_DEBUG && !Yii::app()->request->isAjaxRequest) 
		{
			throw new CHttpException('403', 'Forbidden access.');
		}
   
		if (empty($_POST['LeadGen']['int_fabrikat'])) 
		{
			throw new CHttpException('404', 'Missing parameter.');
		}			
		*/
		
		//$model_id = (int) ($_POST['LeadGen']['int_fabrikat']));  // the selected model
		
		$model_id = 184; 	// audi debug
		
		$sql = Yii::app()->db->createCommand();
		$sql->select('aus_id');									// vehicle/trim_id
		$sql->from('{{modelle}}');								// will prepend country
		$sql->join('{{ausstattung}}', 'aus_modell=mod_id');
		$sql->where('mod_fabrikat=:vehicle_model', array(':vehicle_model' => $model_id));
		$sql->order('rand()');
		$sql->limit(3);	
		
		$model_trims = $sql->queryAll();
		
		// var_dump( $model_trims[0]['aus_id']);
		
		$cnt = count($model_trims);		// 0 to 3 results
		
		$photo_paths = array();
		
		if($cnt)
			foreach ($model_trims as $id) 
			{
				 echo '<br> aus_id : ' . $id['aus_id'] . ' ' . $this->get_pic($id['aus_id'])  . '<br>' ;
				
				// get the image file names, save to array (push on end)
				
				$photo_paths[] =$this->get_pic($id['aus_id']); 
			}
		
		echo json_encode($photo_paths); // ships it as a nice jason compatible array
	}

	public function actionPhotoModel()
	{
	}
	
	
	public function actionPhotoTrim()
	{
	}


	/*
	* This is where most of the navigation and page state work is done. We never change the page url
	* but we render each page until the end. Note this is a poor man's state machine. Remember
	* the $_POST contains the form for the page that is sending the request. If no matches for any
	* known page we have a NEW user on the landing page so deliver a fresh set.
	*/

	public function actionLanding()
	{
		if(isset($_POST['landing']))	// If here you came from the quote page using a back button (optional)
		{
			$model = new LeadGen('landing');
      
			/*
			* Always remove any leftover Trim and Color data as we can't
			* ensure we have valid time or color data if make or model has changed
			* and causes selects to reset
			*/
			
			unset($_POST['LeadGen']['trim']);
			unset($_POST['LeadGen']['color']);
		
			$this->checkPageState($model, $_POST['LeadGen']);
			$model->scenario = 'landing';	// set validation scenario to landing page 
			$view = 'landing';
		}
		else  // transistion landing page to quote page
			if(isset($_POST['quote'])) 
			{ 
				$model = new LeadGen('landing');
				$this->checkPageState($model, $_POST['LeadGen']);	// get all the post params (form vars) and save to the current state
			
				if($model->validate())			// validate the prior page now, if OK set up current, if not get ready for the bounce back to the landing page
				{
					// Validate on landing page is good, not this is just the 'landing' scenario at this point not the whole set of pages
				
					$view = 'quote';
					$model->scenario = 'quote';
				}
				else
				{
					// oops, landing page fields didn't validate, back to the landing page (current scenario is landing still)
					
					$view = 'landing';	// back to page one if the data on page one was invalid. 
				}
			}
			else // submit the complete set of data. 
				if(isset($_POST['submit'])) 	// quote page has form submitted, get form data validate and save it!
				{
					$model = new LeadGen('quote');
					$model->attributes = $this->getPageState('page', array()); // tricky, gets the state into the model, then erases it 

					$model->attributes = $_POST['LeadGen'];
					  
					if($model->validate())	
					{
						// we have valid data
						
						//$model->params = $_REQUEST;		// can be refined to get a specific param, just grab anything now
						$model->save();
						$view = 'confirmation';		// jump to the confirmation page
						
						// at this point $model->int_id has the key for the inthae table inserts

						// First any of the special dealers 
						
						if(isset($_POST['Inthae']['special_dlrs']))
						{
							$sdl = $_POST['Inthae']['special_dlrs'];
							foreach($sdl as $dlr)
							{
								$prospect_sdlr = new Inthae;	
								$prospect_sdlr->ih_prospect_id = $model->int_id; 	// current models updated id
								$prospect_sdlr->ih_dealer_id = $dlr;
								$prospect_sdlr->ih_status = 1;						// database value for special dealers = 1
								
								if (!$prospect_sdlr->save()) 
									print_r($$prospect_sdlr->errors);
							}
						}

						// Now the 'More' dealers, same table just from different form element
						
						if(isset($_POST['Inthae']['more_dlrs']))
						{
							$mdl = $_POST['Inthae']['more_dlrs'];
							foreach($mdl as $dlr)
							{
								$prospect_mdlr = new Inthae;	
								$prospect_mdlr->ih_prospect_id = $model->int_id; 	// current models updated id
								$prospect_mdlr->ih_dealer_id = $dlr;
								$prospect_mdlr->ih_status = 0;						// database value for regular = 0
								
								if (!$prospect_mdlr->save()) 
									print_r($$prospect_mdlr->errors);
							}
						}
					}
					else
					{
						// validation failed go back to the quote page and do it again
						  					
						$view = 'quote';	// fix up errors
					}
				}
				else // New user landing here, didn't come from quote page send to the landing page (landing.php)
				{
					$model = new LeadGen('landing');
					$view = 'landing';
					$model->scenario = 'landing';	// set validation scenario to landing page 
				}
    
		// hack to make browser back button work by enabling the page to be cached
		// otherwise you get the dreaded 'Re-send data popup'
		
		$expires = 300;  // in secs
		header("Content-Type: text/html; charset: UTF-8");
		header("Cache-Control: max-age={$expires}");
//		header("Cache-Control: max-age={$expires}, public, s-maxage={$expires}");
		header("Pragma: ");
		header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . ' GMT');
    
		$this->render($view, array('model'=>$model));	// render correct view with current model state
	}

	
	/**
	* @return array action filters
	* sjg - needs some work. No delete ever needed, not using access crotrol or crud stuff
	*/
	 
	public function filters()
	{
		return array(
			'accessControl', 			// perform access control for CRUD operations
			'postOnly + delete', 		// we only allow deletion via POST request
		);
	}

	/**
	* Specifies the access control rules.
	* This method is used by the 'accessControl' filter.
	* @return array access control rules
	*/
 
	public function accessRules()
	{
		/*
		* Only allow the 3 pages and the lookup functions to be accessable
		*/
		
		return array(
			array('allow',  // allow all to look at the pages and lookups
				'actions'=>array('landing', 'quote', 'confirmation', 
				'models', 'trims', 'colors', 'dealers', 'photomakes'),  // added create to all users no login needed 
				'users'=>array('*'),
			),

			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update'),
				'users'=>array('@'),
			),
			
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/*
	* checkPageState manages the data from page to page in the sequence.
	* The model's attributes (form fields) get set and assigned to the 'page' state.
	* 
	* $model gets the current state on return
	* data is the current forms state that is going to be set to the $model's attributes (form fields)
	* and finally set the current page state to the controllers internal state (Not 100% what to call this)
	*/
	
	private function checkPageState(&$model, $data)
	{
		$model->attributes = $this->getPageState('page', array());
		$model->attributes = $data;
		$this->setPageState('page', $model->attributes);
	}

	/**
	* This is the action to handle external exceptions.
	*/
	 
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}
