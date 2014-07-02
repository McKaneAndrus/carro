<?php
class SiteController extends Controller
{
	// note the default image is not in the image directory with the cars,
	// it's in the app's image directory to keep deployment easy
	
	const DEFAULT_NOT_FOUND_CAR_PIC =  '/images/no_pic.jpg';	// picture not found path (keep leading slash)
	const DEFAULT_URL_IMAGE_PATH = '/images/cars/';		// default path (url) to real images (not no_pic.jpg)
	const DEFAULT_URL_LOGO_PATH = '/images/logos/';				// default path (url) to  images
	const DEFAULT_NOT_FOUND_LOGO_PIC =  '/images/1x1.gif';		// picture not found path (keep leading slash)
	const DEFAULT_MAIL_CAR_IMAGE_PATH = '../../..';				// path to car images from mail (config/mail.php) image path
	const DEFAULT_ANY_VALUE = -1;								// change with caution, hard coded value in javascript
	const DEFAULT_DUPE_CHECK_DAYS = 7;							// Length of time to check back for dupes (in the last X days check)
	
	const LANDING_PAGE_ID = 1000;								// Page Id's for logging
	const QUOTE_PAGE_ID	= 1001;
	const CONFIRM_PAGE_ID = 1002;
		
	/*
	* Default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'. We
	* use a single column as that's how we do these pages
	*/
	
	public $layout='//layouts/column1';	// Single layout no columns

	/*
	* Default Page for site should be the landing
	*/
	
	public $defaultAction = 'landing';	

	/*
    * Turn any object (e.g., an array) into a string you can save in a cookie
    * @param object $obj
    * @return string
    *
    * Remeber limits on size of cookie data
    */
    
    function CookieEncode($obj) 
    {
		$value = json_encode($obj);
		$value = base64_encode($value);
		return $value;
    }
     
    /*
    * Turn a string encoded by cookie_encode back into an object
    * @param string $value
    * @return object
    */
    
    function CookieDecode($value) 
    {
		$value = base64_decode($value);
		$value = json_decode($value, true);
		return $value;
    }

	/*
	* Send an email to the AWS Simple Email Service. This is a specific call to SES
	* but might later decouple the email parameters and put in a config
	*
	* $send_addr - Address to send the email to
	* $subject - subject line of the email
	* $template_name - name of the yii view to use, something in the protected/views/mail
	* $template_data - all the required data that the template you use needs, validating data is up to the view
	*
	* If the email fails, only a warning is put into the Yii application log with the email address
	*/

	function SES_SendEmailAck($send_addr, $subject, $template_name, $template_data) 
	{
		if(YII_DEBUG)
			Yii::log("Sending Email",  CLogger::LEVEL_INFO);
	
		if(!is_array($template_data))
		{
			Yii::log("Invalid template_data, it's not an array.",  CLogger::LEVEL_WARNING);
			return;
		}	
		
		$mail = new YiiMailer();

		// $mail->SMTPDebug  = 1;		// debug and messages lots of output to webpage

		$mail->IsSMTP(true);												// use SMTP
		$mail->SMTPAuth   = true;											// enable SMTP authentication
		$mail->Host       = "tls://email-smtp.us-east-1.amazonaws.com";		// Amazon SES server, note "tls://" protocol
		$mail->Port       = 465;                    						// set the SMTP port
		$mail->Username   = "AKIAII7CIQ5C6QM2KR4A";  						// SES SMTP username
		$mail->Password   = "AsgnPhn+UkFTCEQ7GqjABNb6k6b5AGeZZBmu8YQD9PDW"; // SES SMTP password

		$mail->setView($template_name);		// this is the view to render for the email
		$mail->setData($template_data);		// pass the data long to the view
		
		if(!isset(Yii::app()->params['AckEmailAdr']))
		{
			Yii::log("AckEmailAdr application variable not set, check config file",  CLogger::LEVEL_WARNING);
			return;
		}
		
		
		if(!isset(Yii::app()->params['AckEmailName']))
		{
			Yii::log("AckEmailName application variable not set, check config file",  CLogger::LEVEL_WARNING);
			return;
		}
		
		$mail->setFrom(Yii::app()->params['AckEmailAdr'], Yii::app()->params['AckEmailName']);
		$mail->setTo($send_addr);
		$mail->setSubject($subject);

		if(!$mail->send()) 
			Yii::log("Can't Send Acknowledge Email to : " . $send_addr,  CLogger::LEVEL_WARNING);
	}

	/*
	* Given a dealer id's will return a list of dealer info useful for 
	* display or email, etc. 
	* 
	* Format is an array of dealer info elements as such for each 
	*		( 'id'='123', (redundant, but might be useful bundled)
	*		  'name' => 'Dealers name',
	*		  'street' => '1234 Any Street',
	*		  'city' => 'Your City',
	*		  'state' => 'Some State'
	*		  'postal' => '012345-123',
	*		  'phone' => '123-342-435'
	*		)
	* >> Add any needed elements to the query and return <<
	*		 
	* returns the list, or an empty array if not found
	*/
	
	public function GetDealerInfo($dlr_id)
	{
		$sql = Yii::app()->db->createCommand();
		$sql->select('hd_id, hd_name, hd_str, hd_ort, hd_state, hd_plz, hd_tel');
		$sql->from('{{haendler}}');									// will prepend country
		$sql->where('hd_id=:dlr_id', array(':dlr_id' => $dlr_id));
		$rec = $sql->queryRow();	 // false if nothing set, row record otherwise
			
		if($rec)
		{
			$dlr_rec =	array(
						'id' 		=> $rec['hd_id'], 
						'name'		=> $rec['hd_name'],
						'street'	=> $rec['hd_str'],
						'city' 		=> $rec['hd_ort'],
						'state'		=> $rec['hd_state'],
						'postal'	=> $rec['hd_plz'], 
						'phone'		=> $rec['hd_tel']
					);
		}
		else
			$dlr_rec = array();

		return($dlr_rec);
	}

	/*
	* Given a make id this will get the logo. Currently their is 
	* only one size logo 56px tall and a variety of widths
	*
	* Params -
	* 	$make_id - int make id
	*
	* Returns -
	*
	*	string to the  full url to the image, or false if not found.
	*/
	
	public function GetMakeLogo($make_id)
	{

		if(!is_numeric($make_id))
		{
			Yii::log("Invalid make_id, it's non-numeric",  CLogger::LEVEL_WARNING);
			return false;
		}

		$url_logo_path = self::DEFAULT_URL_LOGO_PATH; 									// can be different then file path
		$file_check_path = $_SERVER['DOCUMENT_ROOT'] . self::DEFAULT_URL_LOGO_PATH;		// MUST NOT BE RELATIVE PATH
		
		// Check for .png primary  and .jpg fallback as the only valid extensions

		$image_name = $make_id . '.png';				// primary logo type

		if (file_exists($file_check_path . $image_name))
			return $url_logo_path . $image_name;		// should be something like /var/www/html/logo/123.png when all done

		$image_name = $make_id . '.jpg';				// secondary logo type

		if (file_exists($file_check_path . $image_name))
			return $url_logo_path . $image_name;		// should be something like /var/www/html/logo/123.jpg when all done
			
		return false;
	}

	public function GetPic($trim_id)
	{
		/*
		* The $url_image_path is use for final generation of the web based URL of the image. 
		* This is typically a relative path from webroot or application root. The problem is
		* that PHP's file_exists() does not work for relative paths and a absolute path is needed
		* to make it work. So the paths for URL and for Filesysytem are handled independantly.
		* 
		* $_SERVER['DOCUMENT_ROOT'] is typically something like '/var/www/' or '/var/www/html/ ......'
		*
		* $trim_id - trim_id
		*
		* $url_image_path - path prepended to image filename returned to caller
		* $file_check_path - Absolute filesystem path to the file 
		* $p_filename - valid filename of an image, default is set at start of function!
		* 
		* This doesn't query on the status of any tables used so images can be
		* retreived for active or inactive records
		*
		* RETURNS : Array of lots of stuff or false if nothing found, note image is URL ENCODED!!!
		*
		* @todo sjg - add parameter to allow enforcement of the status flags in ALL
		* 			  queries
		*/

		$url_image_path = self::DEFAULT_URL_IMAGE_PATH; 					// can be different then file path
		$file_check_path = $_SERVER['DOCUMENT_ROOT'] . self::DEFAULT_URL_IMAGE_PATH;		// MUST NOT BE RELATIVE PATH
		$p_filename = false;

		if(is_numeric($trim_id))
		{

			$sql = Yii::app()->db->createCommand();
			$sql->select('aus_id, aus_modell, aus_body_id, aus_doors');		// vehicle/trim_id
			$sql->from('{{ausstattung}}');									// will prepend country
			$sql->where('aus_id=:trim_id', array(':trim_id' => $trim_id));
			$rec = $sql->queryRow();	 // false if nothing set, row record otherwise
						
			if($rec)
			{
				// -- Get model text
		   
				$sql1 = Yii::app()->db->createCommand();
				$sql1->select('mod_id, mod_path, mod_text, mod_fabrikat');	// vehicle/trim_id
				$sql1->from('{{modelle}}');									// will prepend country
				$sql1->where('mod_id=:model_id', array(':model_id' => $rec['aus_modell']));
				$rec1 = $sql1->queryRow();

				if($rec1 == false)
					return false;
					
				$mod_text = $rec1['mod_text'];	// get the nice year, make, model text
					
				$p_year = intval(substr($rec1['mod_text'], 0, 4));
			   
				// -- If year is unknown, it's impossible to find photos
			   
				if ($p_year >= 1990)
				{
					// -- Get make name
				  
					$sql2 = Yii::app()->db->createCommand();
					$sql2->select('fab_id, fab_bez');					// vehicle/trim_id
					$sql2->from('{{fabrikate}}');						// will prepend country
					$sql2->where('fab_id=:make_id', array(':make_id' => $rec1['mod_fabrikat']));
					$rec2 = $sql2->queryRow();
				  
					if($rec2 == false)
						return false;
				  
					// build path based on  make, model, year, doors, body type (JATO Specific)
					// file names need no encoding, URL's do
					// $image_suffix has the image suffix in order of importance	

					$image_suffix = array('_45.JPG', '_135.JPG', '_0.JPG', '.JPG', '-4_45.JPG', '-4_135.JPG', '-4_0.JPG', '-4.JPG');
					$image_ydb = $p_year . '/' . $rec['aus_doors'] . $rec['aus_body_id'];

					// if here we have valid records so we can get trim, make, model from them
					
					foreach($image_suffix as $suffix)
					{
						if (file_exists($file_check_path . strtoupper($rec2['fab_bez']) . '/' . 
										strtoupper($rec1['mod_path']) . '/' . $image_ydb . $suffix))
						{
							// Exit here if we find it, otherwise we return false at the bottom
							// return is in the form of an array with 'image_path' and 'image_desc' as
							// keys to get at the data
							
							$image_path = $url_image_path . rawurlencode(strtoupper($rec2['fab_bez'])) . '/' . 
											rawurlencode(strtoupper($rec1['mod_path'])) . '/' . $image_ydb . $suffix;
									
							// The result set contains an array of these elements which are useful!
											
							return array(	'image_path' => $image_path, 
											'image_desc' => $mod_text, 
											'fab_id' => $rec2['fab_id'],
											'mod_id' => $rec1['mod_id'],
											'aus_id' => $rec['aus_id']
										);
						}
					} // foreach
				} // year > 1990
			} // found a modell record
		} // $trim_id was specified
		
		return false;	// if here then not found
	}

	/*
	* Simple check to see if the prospect has been already added to the interstessten table.
	* It looks for a matching email address, make, model to see if it has been added already
	* 
	* $email - email address of prospect
	* $make - make ID of the vehicle
	* $model - model ID of the vehicle
	*
	* more advanced checking could be done here as well.
	*
	* returns true if a dupe or false if not found
	*/
	
	public function ProspectDupeCheck($email, $make_id, $model_id)
	{

		if(!isset(Yii::app()->params['EmailDupeDays']))
		{
			Yii::log("EmailDupeDays application variable not set, check config file, default value used",  CLogger::LEVEL_WARNING);
			$num_days = self::DEFAULT_DUPE_CHECK_DAYS;
		}
		else
			$num_days = Yii::app()->params['EmailDupeDays'];

		if($num_days == 0)	// skip the call to the db returns not found
			return false;
			
		$criteria = new CDbCriteria();
		$criteria->condition = 'int_mail=:email AND int_fabrikat=:make AND int_modell=:model and (int_anlage + INTERVAL :num_days DAY > NOW())';
		$criteria->params = array(':email'=>$email, ':make'=>$make_id, ':model'=>$model_id, ':num_days'=>$num_days);
		
		return LeadGen::model()->exists($criteria); 
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
	*
	* Currently the postal code can be a 5 digit or a 9 digit in either of these formats
	*    12345 or 12345-123
	*
	* The dash must be in the long version.
	* 
	* returns a 9 digit code
	*/
	
	public function NormalizePostalCode($postal_code_str)
	{
		
		$len = strlen($postal_code_str);
		
		if($len == 5)
			return $postal_code_str . '-000'; // format came in as just the 5 digit
		else
			if($len == 9)
				return $postal_code_str;		
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
	*
	* Note this uses the EXTENDED_POSTAL_CODE table
	*/
	
	public function GetCityState($postal_code_str)
	{
		$postal_code_str = $this->NormalizePostalCode($postal_code_str);	// this is Brazil CEP code specific and must match our data

		$sql = Yii::app()->db->createCommand();
		$sql->select('city, state');
		$sql->from('{{extended_postal_codes}}');									// will prepend country
		$sql->where('code=:postal_code', array(':postal_code' => $postal_code_str));
		$rec = $sql->queryRow();	 // false if nothing set, row record otherwise
	
		if($rec == false)
		{
			$city_state['city'] = Yii::t('LeadGen', 'Unknown City');
			$city_state['state'] = Yii::t('LeadGen', 'Unknown State');
		}
		else
		{
			$city_state['city'] = $rec['city'];
			$city_state['state'] = $rec['state'];
		}

		return $city_state;	// record with City, State, if no match lang specific unknown text
	}

	/*
	* Given a state and a city will return the postal code. This may
	* not work correcly for all countries, but for Brazil the mapping
	* seems to hold true. 
	*
	* NOTE : This uses the EXTENDED table, and better have indexes on city and state!
	*/
	
	public function GetPostalCode($city, $state)
	{

		$sql = Yii::app()->db->createCommand();
		$sql->select('code');
		$sql->from('{{extended_postal_codes}}');									// will prepend country
		$sql->where('state=:state_str and city=:city_str', array(':state_str' => $state, ':city_str' => $city));
		$rec = $sql->queryRow();	 // false if nothing set, row record otherwise

		if($rec == false)
			return '00000-000';
			
		return $rec['code'];
	}

	/*
	* Get the Make name (string) from a make ID. 
	* currently if unknown we return default
	*
	* $make_id is currently an integer for the make
	* Returns : string name of the make
	*
	*/
	
	public function GetMakeName($make_id)
	{
		$sql = Yii::app()->db->createCommand();
		$sql->select('fab_bez');
		$sql->from('{{fabrikate}}');									// will prepend country
		$sql->where('fab_id=:make_id', array(':make_id' => $make_id));
		$rec = $sql->queryRow();	 // false if nothing set, row record otherwise

		if($rec == false)
			return Yii::t('LeadGen', 'Unknown Make');
			
		return $rec['fab_bez'];
	}
	
	/*
	* Get the Model name (string) from a model ID. 
	* currently if unknown we return default
	*
	* $model_id is currently an integer for the model
	* Returns : string name of the model
	*
	*/
		
	public function GetModelName($model_id)
	{
		$sql = Yii::app()->db->createCommand();
		$sql->select('mod_bez');
		$sql->from('{{modelle}}');									// will prepend country
		$sql->where('mod_id=:model_id', array(':model_id' => $model_id));
		$rec = $sql->queryRow();	 // false if nothing set, row record otherwise

		if($rec == false)
			return Yii::t('LeadGen', 'Unknown Model');
			
		return $rec['mod_bez'];
	}
	
	/*
	* Get the Model text (string) from a model ID. 
	* Model text is Year, Make, Model 
	*
	* currently if unknown we return default translated text
	*
	* $model_id is currently an integer for the model
	* Returns : string text field of the model (year, make, model) format as defined by JATO
	*
	*/
		
	public function GetModelText($model_id)
	{
		$sql = Yii::app()->db->createCommand();
		$sql->select('mod_text');
		$sql->from('{{modelle}}');									// will prepend country
		$sql->where('mod_id=:model_id', array(':model_id' => $model_id));
		$rec = $sql->queryRow();	 // false if nothing set, row record otherwise

		if($rec == false)
			return Yii::t('LeadGen', 'Unknown Model');
			
		return $rec['mod_text'];

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
		if($trim_id == self::DEFAULT_ANY_VALUE)	// our default id for ANY which is not in the database
			return(Yii::t('LeadGen', 'Any Trim'));
		
		$sql = Yii::app()->db->createCommand();
		$sql->select('aus_bez');
		$sql->from('{{ausstattung}}');						// will prepend country
		$sql->where('aus_id=:trim_id', array(':trim_id' => $trim_id));
		$rec = $sql->queryRow();	 // false if nothing set, row record otherwise

		if($rec == false)
			return Yii::t('LeadGen', 'Unknown Trim');
			
		return $rec['aus_bez'];
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
		if($color_id == self::DEFAULT_ANY_VALUE)	// our default id for ANY which is not in the database
			return(Yii::t('LeadGen', 'Any Color'));
		
		$sql = Yii::app()->db->createCommand();
		$sql->select('farb_bez');
		$sql->from('{{farben}}');						// will prepend country
		$sql->where('farb_id=:color_id', array(':color_id' => $color_id));
		$rec = $sql->queryRow();	 // false if nothing set, row record otherwise

		if($rec == false)
			return Yii::t('LeadGen', 'Unknown Color');
			
		return $rec['farb_bez'];
	}

	/*
	* Given all Makes, will generate an HTML list data of id, name for use
	* in such places as select fields.
	*
	* Returns array of model_id, name for building the html select field
	*/
	
	public function GetMakes()
	{
		$sql = Yii::app()->db->createCommand();
		$sql->select('fab_id, fab_bez');
		$sql->from('{{fabrikate}}');						// will prepend country
		$sql->where('fab_status=0');						// active makes = 0
		$sql->order('fab_bez');
		
		$makes = $sql->queryAll();	 

		return CHtml::listData($makes, 'fab_id', 'fab_bez');	// fields from the model table
	}

	/*
	* Given a Make Id will generate an HTML list data of associated model for use
	* in such places as select fields.
	*
	* Uses mod_status to determine if the record is visible in the display
	*
	* Returns array of model_id, name for building the html select field
	*/
	
	public function GetModels($make_id)
	{
		$sql = Yii::app()->db->createCommand();
		$sql->select('mod_id, mod_bez');
		$sql->from('{{modelle}}');						// will prepend country
		$sql->where('mod_fabrikat=:make_id and mod_status=0', array(':make_id'=>$make_id));					// active makes = 0
		$sql->order('mod_bez');
		
		$models = $sql->queryAll();	 

		return CHtml::listData($models, 'mod_id', 'mod_bez');	// fields from the model table
	}

	/*
	* Given a Trim_Id will return a URL for the image. Basically a wrapper around GetPic 
	* but will back fill with a MODEL image for any trims that do not exist. 
	* If a model specific trim does not exist then the no_pic defualt image is returned
	*
	* Returns array with 'image_path' and 'image_desc' 
	*/

	public function GetTrimImage($trim_id)
	{
			
		if(($pic = $this->GetPic($trim_id)) !== false)
		{ 
			$image_data = $pic;
		}
		else  // backfill empty images if we can't come up with any, fix up text to be valid info
		{
			// Do a join on the trim to iself to find all trim ID's with same model EXCLUDING
			// the current trim since we hav already check that, save multiple db calls
			// SELECT t2.aus_id FROM br_ausstattung AS t1, br_ausstattung AS t2 WHERE t1.aus_id = 7003609 AND t1.aus_modell = t2.aus_modell AND t1.aus_id != t2.aus_id;
			
			$sql = Yii::app()->db->createCommand();
			$sql->select('t2.aus_id');
			$sql->from('{{ausstattung}} as t1, {{ausstattung}} as t2');									// will prepend country
			$sql->where('t1.aus_id=:trim_id AND t1.aus_modell = t2.aus_modell AND t1.aus_id != t2.aus_id;and aus_status=0', array(':trim_id'=>$trim_id));
			$trims = $sql->queryall();

			$image_data = array();

			foreach($trims as $id)
			{
				if(($pic = $this->GetPic($id['aus_id'])) !== false)
				{ 
					$image_data = $pic; 	// same as array_push()
					break;	// stop after we find ANY match, yes, it's totally arbitrary
				}
			}

			// at this point if we have not found any images for any trims of the same model, 
			// have to go with the default image image...
			
			if(empty($image_data))
				$image_data = array('image_path' => Yii::app()->request->baseUrl . self::DEFAULT_NOT_FOUND_CAR_PIC, 'image_desc' => Yii::t('LeadGen', 'Sorry, No Image Available'));
		}
		
		return $image_data;	// has 'image_path' and 'image_desc' elements (see get_pic())
	}

	/*
	* Given a Model Id will return a URL for the image. Note that this
	* will return the first image associated with the models trims since
	* images are associated with a trim and give just a model you have no 
	* way of knowing what the trim is. 
	*
	* Returns array with 'image_path' and 'image_desc' 
	*/

	public function GetModelImage($model_id)
	{
		$sql = Yii::app()->db->createCommand();
		$sql->select('aus_id');										// vehicle/trim_id
		$sql->from('{{ausstattung}}');								// will prepend country
		$sql->where('aus_modell=:vehicle_model', array(':vehicle_model' => $model_id));
		$sql->limit(5);		// get more then we think so empty images can be skipped
		$make_trims = $sql->queryAll();
		
		$cnt = count($make_trims);
		$image_data = array();
		
		// scan the list for at least 1 valid as that is all we are displaying
		
		if($cnt)
		{
			$valid_images = 0;
			foreach ($make_trims as $id) 
			{
				// get the image file names if valid, save to array 
			
				if(($pic = $this->GetPic($id['aus_id'])) !== false)
				{ 
					$image_data = $pic; 	// same as array_push()
					break;
				}
			}
		}
		
		// backfill empty images if we can't come up with any, fix up text to be valid info

		if(count($image_data) < 1)
		{
			$text = $this->GetModelText($model_id);	// always returns valid string or default unknown
			$image_data = array('image_path' => Yii::app()->request->baseUrl . self::DEFAULT_NOT_FOUND_CAR_PIC, 'image_desc' => $text);
		}
		
		return $image_data;	// has 'image_path' and 'image_desc' elements (see get_pic())
	}

	/*
	* Get a list of the states from the postal code table. This combined
	* with the city should map to a postal code. 
	* 
	* For the br_postal_codes table a mapping of state and city deliver
	* a unique postal code (or so I think).
	*
	* This must NOT use the extended postal codes table, only the postal_codes
	*/
	
	public function GetStates()
	{

		$sql = Yii::app()->db->createCommand();
		$sql->select('state');
		$sql->from('{{postal_codes}}');									// will prepend country
		$sql->order('state');
		$states = $sql->queryall();
	
		return CHtml::listData($states, 'state', 'state');	// fields from the model table
	}

	/*
	* Get a list of the cities from given state from the postal code table. 
	*  
	* For the br_postal_codes table a mapping of state and city deliver
	* a unique postal code (or so I think).
	*
	* CAUTION : THIS ASSUMES THAT THE CITY IS UNIQUE TO A SINGLE ZIP CODE
	* >>>>> This must NOT use the extended postal codes table, only br_postal_codes which makes the above true
	*
	*/

	public function GetCities($state)
	{
		$sql = Yii::app()->db->createCommand();
		$sql->select('city');
		$sql->from('{{postal_codes}}');									// will prepend country
		$sql->where('state=:state', array(':state'=>$state));
		$sql->order('city');
		$cities = $sql->queryall();

		return CHtml::listData($cities, 'city', 'city');
	}

	/*
	* Given a Model Id will generate an HTML list data of id, name for use
	* in such places as select fields.
	*
	* Uses aus_status to determine if the record is visible in the display
	*
	* Returns array of trim_id, name for building the html select field
	*/
	
	public function GetTrims($model_id)
	{
		// set up query, make easy to read and change
		
		$sql = Yii::app()->db->createCommand();
		$sql->select('aus_id, aus_extended_trim');
		$sql->from('{{ausstattung}}');									// will prepend country
		$sql->where('aus_modell=:id_trim_model and aus_status=0', array(':id_trim_model'=>$model_id));
		$sql->order('aus_extended_trim');
		
		// might want to group on aus_extended_trim...
		
		$trims = $sql->queryall();
	
		return CHtml::listData($trims, 'aus_id', 'aus_extended_trim');	// fields from the model table, use unique extended trim
	}

	/*
	* Given a Trim Id will generate an HTML list data of id, name for use
	* in such places as select fields.
	*
	* Returns array of color_id, name for building the html select field
	*/

	public function GetColors($trim_id)
	{
		$sql = Yii::app()->db->createCommand();
		$sql->select('mf_farbe, farb_bez as color');
		$sql->from('{{modellfarben}} as mf');									// will prepend country
		$sql->join('{{farben}}', 'mf_farbe = farb_id');							// joins the modelcolor with the color
		$sql->where('mf_trim=:id_color_trim and farb_status=0', array(':id_color_trim' => (int) $trim_id));
		$sql->order('color');
		$colors = $sql->queryall();

		return CHtml::listData($colors, 'mf_farbe', 'color');	// fields color ID and name
	}

	/*
	* Proc returns number max number of results for a given distance of a user from a dealer
	* 
	* Params :
	* 	make - dealers fabrikat field 
	*   user_postal_code - users postal code (start point)
	*   dist - max distince in Kilometers for the bounding square away from dealer
	*   limit - the max number of results (default 10)
	* 
	* This normalized the postal code prior to calling the sp.
	*/
	
	public function GetNearestDealer($make, $postal_code_str, $dist, $limit = 10)
	{

		$postal_code_str = $this->NormalizePostalCode($postal_code_str);	// this is Brazil CEP code specific and must match our data

		$q = 'CALL P_br_dealer_distance_ext_km(:make_id, :user_postal_code, :distance_km, :max_results)';
		$cmd = Yii::app()->db->createCommand($q);
		$cnt = 0;

		$cmd->bindParam(':make_id', $make, PDO::PARAM_INT); // set the so we can look at dealers make!
		$cmd->bindParam(':user_postal_code', $postal_code_str, PDO::PARAM_STR);
		$cmd->bindParam(':distance_km', $dist, PDO::PARAM_INT);
		$cmd->bindParam(':max_results', $limit, PDO::PARAM_INT);
		$dealers = $cmd->queryAll();
		
		return $dealers;
	}

	/*
	* Proc returns number max number of results for a given distance of a user from a dealer
	* Indexes may help on some items
	*
	* The algo below basically can call the sp a few times. This proc is expensive so
	* keep loop count low. The idea is to geometrically increase the size of the
	* distance and requery until a suitable amount of dealers are found. If the number
	* of tries is exceeded then you get what was found.
	* 
	* The distance used for the start ($dist) should be chosen accordingly, see GetNearestDealer() for
	* Parameters
	*
	* This function returns data in a html list box format
	*/
	
	public function GetDealers($make, $postal_code_str, $limit)
	{
	
		$dist = 100;	// 100 sq km box for the start, remember ordered by distance
		$cnt = 0;

		do
		{
			$dealers = $this->GetNearestDealer($make, $postal_code_str, $dist, $limit);
			
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
			'<br>' . CHtml::encode($dealers['hd_ort'] . ', ' .  $dealers['hd_state']) .
			'<br>' . CHtml::encode($dealers['hd_plz']) . 
			'<br>' . CHtml::encode($dealers['hd_tel']).
			'<br>' . CHtml::encode(Yii::t('LeadGen','Distance') . ' : ' . (($dealers['distance'] > 5.0)? $dealers['distance'] . ' km' : Yii::t('LeadGen','Local')));
		});
	}

	/*
	* Simple helper to get a list of the check box options for the quote page
	*/
	
	public function getQuoteOptions()
	{
		// set up query, make easy to read and change
		
		$sql = Yii::app()->db->createCommand();
		$sql->select('value, display');
		$sql->from('{{ncp_quote_opts}}');						// will prepend country
		$sql->where('status=0 and cob_id=0');					// specific cobrand id needed if other then 0 for the app
		$sql->order('display_order');
		$opts = $sql->queryall();
	
		return CHtml::listData($opts, 'value', 'display');	// fields from the model table, use unique extended trim
	}
	
	/*
	* getConquest returns a list of cars that match the give src values. You can specify
	* a maximum number of results to return. Currently this should be set to 1 until this 
	* has more logic to process a list of possibly conquest results ranked by something.
	* This also does NOT take into consideration any ordering due to multiple campaigns 
	* that may be conquesting the same car.
	*
	* src_make, src_model, src_trim - The make, model and trim of a car we want to conquest.
	* 
	* Note - This does some magical stuff, so far here are the rules...
	*
	* If a src_make, src_model and src_trim match the mapped record is returned. Easy Case. 
	* This includes the case where src_trim = -1 where the user may select ANY TRIM all 3 fields are always used
	* for making a match. Note it's perfectly OK to have a src_make, src_mode set to some value with src_trim=-1 mapped to a 
	* specific dest_make, dest_model, and dest_trim where trim != -1 this means it's possible to match JUST the 'any trim' option
	* to a specific mapped destination. This is confusing and should be avoided. IF a mapped record has
	* src_trim = -1, good idea to have dest_trim = -1
	*
	* If no exact match is found, the query is opened up to try to match JUST the src_make and
	* src_model (ignoring the the src_trim). The special match all record must exist with the dest_trim = -1 (match all).
	* 
	* The special record is a catch all if desired, and that should exist in the form of 
	* src_make=a, src_model=b, src_trim= -1, dest_make=x, dest_model=y, dest_trim = -1.
	* the part to note is that both src_trim and dest_trim are -1 
	*/
	
	public function getConquests($src_make_id, $src_model_id, $src_trim_id, $max_results)
	{
		if(!is_numeric($src_make_id) || !is_numeric($src_model_id) || !is_numeric($src_trim_id) || !is_numeric($max_results))
		{
			Yii::log("Invalid parameters, non-numeric",  CLogger::LEVEL_ERROR);
			return false;
		}
			
		// Search for exact match make, model, trim
		// This case will find exact match INCLUDING src trim == -1 (any trim) if that record exists
			
		$sql = Yii::app()->db->createCommand();
		$sql->select('cq_id, cq_text, cm_campaign, cm_conquest_car, cm_dest_make, cm_dest_model, cm_dest_trim, cm_text');
		$sql->from('{{conquest_campaigns}},{{conquest_map}}');		// will prepend country
		$sql->where('cq_id = cm_campaign and cq_status = 0 and cm_status = 0 and cm_src_make = :src_make and cm_src_model = :src_model and cm_src_trim = :src_trim', array(':src_make'=>(int) $src_make_id, ':src_model'=>(int) $src_model_id, ':src_trim'=>(int) $src_trim_id));
		$sql->order('cm_id');
		$sql->limit($max_results);
		$results = $sql->queryall();	// could just do a queryrow...

		// Search for make, model match where the 'any trim' (-1) on dest is set
		// this case will check for a specified src trim that does NOT exist but we need to check for
		// existance of the dest_trim = any (-1) this will NOT match other records with a specified dest trim

		if(count($results) < 1)
		{
			$sql = Yii::app()->db->createCommand();
			$sql->select('cq_id, cq_text, cm_campaign, cm_conquest_car, cm_dest_make, cm_dest_model, cm_dest_trim, cm_text');
			$sql->from('{{conquest_campaigns}}, {{conquest_map}}');		// will prepend country
			$sql->where('cq_id = cm_campaign and cq_status = 0 and cm_status = 0 and cm_src_make = :src_make and cm_src_model = :src_model and cm_src_trim = -1 and cm_dest_trim = -1', array(':src_make'=>(int) $src_make_id, ':src_model'=>(int) $src_model_id));
			$sql->order('cm_id');
			$sql->limit($max_results);
			$results = $sql->queryall();	// could just do a queryrow...
		}

		if(count($results) < 1)
			return false; // nothing to conquest
				
		// decouple db column names into non-db field names
			
		$cars[0] = array();
		$i=0;
		foreach($results as $car)
		{
			/*
			* If we have no text in the map record, go up the hierarchy to get the text field from the conquest_cars
			*/

			if($car['cm_text'] == "")
			{
				$sql = Yii::app()->db->createCommand();
				$sql->select('ccar_text');
				$sql->from('{{conquest_cars}}');		// will prepend country
				$sql->where('ccar_id = :cm_conquest_car and ccar_status=0', array(':cm_conquest_car'=>(int) $car['cm_conquest_car']));
				$results = $sql->queryRow();
			
				if($results !== false)
					$text = $results['ccar_text'];
			}
			else
				$text = $car['cm_text'];
			
			$cars[$i++] = array(
						'campaign_html' => $car['cq_text'],
						'campaign_id' => $car['cm_campaign'],
						'make' => $car['cm_dest_make'], 
						'model' => $car['cm_dest_model'],
						'trim' => $car['cm_dest_trim'],
						'map_html' => $text,
					); // append each record to array
		}
		
		return $cars;
	}
	
	/*
	* Gets the conquest messages for the confirm page. This comes
	* from the cq_text field of the xx_conquest_campaign table. It displays
	* text as contained in the field with no encoding
	*
	* returns : raw text from the table if valid campaign_id, else a default message
	*/
	
	public function getConquestConfirmMsg($campaign_id)
	{
		$sql = Yii::app()->db->createCommand();
		$sql->select('cq_text');
		$sql->from('{{conquest_campaigns}}');		// will prepend country
		$sql->where('cq_id = :campaign_id and cq_status=0', array(':campaign_id'=>(int) $campaign_id));
		$results = $sql->queryRow();
	
		if($results !== false)
			$text = $results['cq_text'];
		else	// default translated message 
			$text = '<h4>' . Yii::t('LeadGen', 'One of the dealers within your neighborhood should contact you within 48 hours to give you great pricing on a car you are looking for.') . '</h4>'; 

		return $text;
	}

	/*
	* ==================== ALL ACTIONS BELOW ====================
	*/


	/*
	* Returns full postal code given state and city in post params
	* called based on the select's ajax call. 
	*
	* returns the postal code in a string or default not found value
	*/

	public function actionPostalCode() 
	{
		if(!isset($_POST['city']) || !isset($_POST['state']))
			throw new CHttpException(400, 'Invalid Request');

		if(!isset($_POST['ajax']))
			throw new CHttpException(403, 'Not authorized');
		$pc = $this->GetPostalCode($_POST['city'], $_POST['state']);
		
		if($pc == '00000-000')	// hack to remove default. 
			$pc = '';
			
		echo $pc;
		
	 }

	/*
	* Returns models given a make id (id_make)
	* called based on the select's ajax call. This given a model will return a list of all the trims
	* that are passed back to the select. This is called directly by component to populate a dependent
	* dropdown.
	*
	* It currently has a couple of default values for the prompt and as well for a default to select
	* ANY so a specific trim may not need to be selected but we stuff the option here	
	*/

	public function actionModels() 
	{
		if(!isset($_POST['LeadGen']['int_fabrikat']))
			throw new CHttpException(400, 'Invalid Request');

		// The post parameters come from the form name, in this case it's LeadGen, with the field value as make
			
		$return = $this->GetModels((int) ($_POST['LeadGen']['int_fabrikat']));

		// if we have results gen the html, always create the default option
		
		echo CHtml::tag('option', array('value' => ""), CHtml::encode(Yii::t('LeadGen', 'Select a Model')), true);		// prompt

		// return the html for the SELECT as <option value="xyz">trimname</option>

		foreach ($return as $modelId => $modelName) 
		{
			echo CHtml::tag('option', array('value' => $modelId), CHtml::encode($modelName), true);
		}
	 }

	/*
	* Returns cities given a state name (string)
	* called based on the select's ajax call. This given a model will return a list of all the cities
	* that are passed back to the select. This is called directly by component to populate a dependent
	* dropdown.
	*/

	public function actionCities() 
	{

		if(!isset($_POST['state_helper']))	// state
			throw new CHttpException(400, 'Invalid Request');

		// The post parameters come from the form name, in this case it's LeadGen, with the field value as state
			
		$return = $this->GetCities($_POST['state_helper']);

		// if we have results gen the html, always create the default option
		
		echo CHtml::tag('option', array('value' => ""), CHtml::encode(Yii::t('LeadGen', 'Select Your City')), true);		// prompt

		// return the html for the SELECT as <option value="xyz">trimname</option>

		foreach ($return as $postalId => $cityName) 
		{
			echo CHtml::tag('option', array('value' => $postalId), CHtml::encode($cityName), true);
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

		echo CHtml::tag('option', array('value' => ""), CHtml::encode(Yii::t('LeadGen', 'Select a Color')), true);			// prompt
		echo CHtml::tag('option', array('value' => self::DEFAULT_ANY_VALUE), CHtml::encode(Yii::t('LeadGen', 'Any Color')), true);	// Any Option

		// return the html for the SELECT as <option value="xyz">trimname</option>

		foreach ($return as $colorId => $colorName) 
		{
			echo CHtml::tag('option', array('value' => $colorId), CHtml::encode($colorName), true);
		}
	}

	/*
	* Ajax call's to return the image name for 
	* HomePagePhotos returns 3 random images for display. These images
	* are initally specified by an entry in the xx_ncp_image table. The
	* image must be active (status=0), and related cobrand (cob_id, not currently used) 
	* and destination set to 0 (Homepage) as a default for now. 
    *
    * IF < 3 images are available from the ncp_images table the next
    * plan is to randomly pic images from the trim table (austattung) and
    * if that fails suff the default empty image name.
    *
	* NOTE NOTE : the rand() order is costly and if too slow, drop this type of sort!!
	*/

	public function actionHomePagePhotos()
	{
		// This should only be allowed to be called by an ajax request, set access rules...

		if(!isset($_POST['ajax']))
			throw new CHttpException(403, 'Not authorized');

		$sql = Yii::app()->db->createCommand();
		$sql->select('model_id');									// model Id
		$sql->from('{{ncp_images}}');
		$sql->where('status=0 and cob_id=0 and destination=0');
		$sql->order('rand()');
		$sql->limit(10);		// get more then we think so empty images can be skipped

		$models = $sql->queryAll();

		$cnt = count($models);
		$photo_urls = array();
		$valid_images = 0;

		// scan the list for 3 valids models that have trim_id's
		
		if($cnt)
		{
			foreach ($models as $id) 
			{
				// get the image file names if valid, save to array (push on end)
	
				$sql1 = Yii::app()->db->createCommand();
				$sql1->select('aus_id');									// vehicle/trim_id
				$sql1->from('{{ausstattung}}');								// will prepend country
				$sql1->where('aus_modell=:vehicle_model', array(':vehicle_model' => $id['model_id']));
				$rec1 = $sql1->queryRow();

				if($rec1)
				{
					if(($pic = $this->GetPic($rec1['aus_id'])) !== false)
					{ 
						$photo_urls[] = $pic; 	// same as array_push()
						$valid_images++;
						
						if($valid_images > 2)	// we need 3 valids
							break;
					}
				}
			}
		}

		// if we don't have any/enough in the ncp_images file then lets go back to just a random hit
		// this prevents bad looking home page if mangled data in ncp_images or user error.
		
		if($valid_images < 3)
		{
			// call to get a random make table is very small so should be fast
			
			$sql = Yii::app()->db->createCommand();
			$sql->select('aus_id');									// vehicle/trim_id
			$sql->from('{{ausstattung}}');
			$sql->where('aus_status=0');
			$sql->order('rand()');
			$sql->limit(10);		// get more then we think so empty images can be skipped
			
			$make_trims = $sql->queryAll();

			$cnt = count($make_trims);
			
			// scan the list to try to back fill
			
			if($cnt)
			{
				$valid_images = 0;
				foreach ($make_trims as $id) 
				{
					// get the image file names if valid, save to array (push on end)
				
					if(($pic = $this->GetPic($id['aus_id'])) !== false)
					{ 
						
						$photo_urls[] = $pic; 	// same as array_push()
						$valid_images++;
						
						if($valid_images > 2)	// we need 3 valids
							break;
					}
				}
			}
		}
		
		// last resort backfill empty images if we can't come up with any
		
		while($cnt < 3)
		{
			$photo_urls[] = array('image_path' => Yii::app()->request->baseUrl . self::DEFAULT_NOT_FOUND_CAR_PIC, 'image_desc' =>'');
			$cnt++;
		}
		
		echo CJSON::encode($photo_urls); // ships it as a nice jason compatible array
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
		// This should only be allowed to be called by an ajax request, set access rules...

		if(!isset($_POST['ajax']))
			throw new CHttpException(403, 'Not authorized');

		if(!isset($_POST['make_id']))
			throw new CHttpException(400, 'Invalid Request');
		
		$make_id = $_POST['make_id'];
		
		if(!is_numeric($make_id))
			throw new CHttpException(400, 'Invalid Request');
	
		$sql = Yii::app()->db->createCommand();
		$sql->select('aus_id, mod_bez');						// vehicle/trim_id
		$sql->from('{{modelle}}');								// will prepend country
		$sql->join('{{ausstattung}}', 'aus_modell=mod_id');
		$sql->where('mod_fabrikat=:vehicle_make', array(':vehicle_make' => $make_id));
		$sql->order('rand()');
		$sql->group('mod_bez');
		$sql->limit(10);		// get more then we think so empty images can be skipped
		
		$make_trims = $sql->queryAll();
	
		$cnt = count($make_trims);
		$photo_urls = array();
		
		// scan the list for 3 valids
		
		if($cnt)
		{
			$valid_images = 0;
			foreach ($make_trims as $id) 
			{
				// get the image file names if valid, save to array (push on end)
			
				if(($pic = $this->GetPic($id['aus_id'])) !== false)
				{ 
					
					$photo_urls[] = $pic; 	// same as array_push()
					$valid_images++;
					
					if($valid_images > 2)	// we need 3 valids
						break;
				}
			}
		}
		
		// backfill empty images if we can't come up with any
		
		$cnt = count($photo_urls);
		while($cnt < 3)
		{
			$photo_urls[] = array('image_path' => Yii::app()->request->baseUrl . self::DEFAULT_NOT_FOUND_CAR_PIC, 'image_desc' =>'');
			$cnt++;
		}
		
		echo CJSON::encode($photo_urls); // ships it as a nice jason compatible array
	}

	public function actionPhotoModel()
	{
		// This should only be allowed to be called by an ajax request, set access rules...
		// also picks up a few models for display and back fill. The code is a bit more
		// then what's needed. An ugly requirement is that we still need a description for images
		// at this point as the user will be needing to see that even if default image is shown
		//
		// Will return an single element unlike the array above in PhotoMakes


		if(!isset($_POST['ajax']))
			throw new CHttpException(403, 'Not authorized');

		if(!isset($_POST['model_id']))
			throw new CHttpException(400, 'Invalid Request');
	
		$model_id = $_POST['model_id'];
		
		if(!is_numeric($model_id))
			throw new CHttpException(400, 'Invalid Request');

		$photo_url = $this->GetModelImage($model_id);

		echo CJSON::encode($photo_url);
	}
	
	public function actionPhotoTrim()
	{
		// This should only be allowed to be called by an ajax request, set access rules...
		// also picks up a few models for display and back fill. 
		// Just fetches the image for a single specific make, if no images, returns the
		// default. This returns a single element NOT an array like it's other counterparts,
		// BUT it still has 2 elements to the array! Note that GetTrimImage MAY backfill with
		// a generic trim from a model if a trim specific image does not exist!!!!

		if(!isset($_POST['ajax']))
			throw new CHttpException(403, 'Not authorized');

		if(!isset($_POST['trim_id']))
			throw new CHttpException(400, 'Invalid Request');
		
		$trim_id = $_POST['trim_id'];
		
		if(!is_numeric($trim_id))
			throw new CHttpException(400, 'Invalid Request');

		$photo_data = $this->GetTrimImage($trim_id);

		echo CJSON::encode($photo_data); // ships it as a nice jason string with image_path, and image_desc as elements
	}

	public function actionMakeLogoImage()
	{
		// This should only be allowed to be called by an ajax request, set access rules...
		// also picks up a few models for display and back fill. 
		// Just fetches the image for a single specific make, if no images, returns the
		// default. This returns a single element NOT an array like it's other counterparts

		if(!isset($_POST['ajax']))
			throw new CHttpException(403, 'Not authorized');

		if(!isset($_POST['make_id']))
			throw new CHttpException(400, 'Invalid Request');

		$make_id = $_POST['make_id'];
		
		if(!is_numeric($make_id))
			throw new CHttpException(400, 'Invalid Request');

		if(($logo_url = $this->GetMakeLogo($make_id)) === false)
			$logo_url = Yii::app()->request->baseUrl . self::DEFAULT_NOT_FOUND_LOGO_PIC;

		echo CJSON::encode($logo_url); // ships it as a nice jason element
	}

	/*
	* This is where most of the navigation and page state work is done. We never change the page url
	* but we render each page until the end. Note this is a poor man's state machine. Remember
	* the $_POST contains the form for the page that is sending the request. If no matches for any
	* known page we have a NEW user on the landing page so deliver a fresh set.
	*
	* Note Each page should also set the title if not using the default make/model in the GET params
	*/

	public function actionLanding()
	{
		
		if(isset($_POST['landing']))	// If here you came from the quote page using a back button (optional, not currently used)
		{

			// $this->updateSessionInfo(self::LANDING_PAGE_ID); 	// track

			$model = new LeadGen('landing');
		
			$this->checkPageState($model, $_POST['LeadGen']);
			$model->scenario = 'landing';	// set validation scenario to landing page 
			$view = 'landing';
		}
		else  // transistion landing page to quote page
			if(isset($_POST['quote'])) 
			{ 
				$model = new LeadGen('landing');
				
				// grab the city and state if set and valid data and look up postal code, for form to 
				// validate city and state (stadt and staat) must have been set (it's ugly I know...)
				// agains assumes a city and state get a unique postal code from the db
	
				$post_params = $_POST['LeadGen'];			// grab post params and add postal code to form state

				if(isset($_POST['LeadGen']['int_plz']) && !empty($_POST['LeadGen']['int_plz']))
				{
					$cs_rec = $this->GetCityState($_POST['LeadGen']['int_plz']);
				
					$post_params['int_stadt'] = $cs_rec['city'];
					$post_params['int_staat'] = $cs_rec['state'];
				}

				$this->checkPageState($model, $post_params);	// get all the post params (form vars) and save to the current state

				if($model->validate())			// validate the prior page now, if OK set up current, if not get ready for the bounce back to the landing page
				{
					// Validate on landing page is good, not this is just the 'landing' scenario at this point not the whole set of pages

					$this->updateSessionInfo(self::QUOTE_PAGE_ID, array('make_id'=>$model->int_fabrikat, 'model_id'=>$model->int_modell)); 	// track 
				
					// update these fields so they can be used even if user changes values
					
					$this->pageTitle = $this->GetMakeName($model->int_fabrikat) . ' ' . $this->GetModelName($model->int_modell) . ' ' . Yii::t('LeadGen', 'GetGet Free New Car Quote') ;

					/* 
					*  Save a cookie of make, model info if desired (mm_hist) may be useful later
					*/
					
					/*
					* $dat = array('make_id' => $model->int_fabrikat, 'model_id' => $model->int_modell);
					* $cookie = new CHttpCookie('mm_hist', $this->CookieEncode($dat));
					* $cookie->expire = time()+60*60*24*180;
					* Yii::app()->request->cookies['mm_hist'] = $cookie;
					*/
					
					$view = 'quote';
					$model->scenario = 'quote';
				}
				else
				{
					// oops, landing page fields didn't validate, back to the landing page (current scenario is landing still)
					
					// $this->updateSessionInfo(self::LANDING_PAGE_ID); 	// track 

					$view = 'landing';	// back to page one if the data on page one was invalid. 
					$this->pageTitle = Yii::t('LeadGen', 'Get Free New Car Quote');
				}
			}
			else // submit the complete set of data. 
				if(isset($_POST['submit'])) 	// quote page has form submitted, get form data validate and save it!
				{
					$model = new LeadGen('quote');

					$this->checkPageState($model, $_POST['LeadGen']); // gets the page state and saves again

					$view = 'confirmation';		// jump to the confirmation page

					$make_name = $this->GetMakeName($model->int_fabrikat);
					$model_name = $this->GetModelName($model->int_modell);
					$this->pageTitle = $make_name . ' ' . $model_name . ' ' . Yii::t('LeadGen', 'Get Free New Car Quote');
  
					if($model->validate())	
					{
						if(!$this->ProspectDupeCheck($model->int_mail, $model->int_fabrikat, $model->int_modell))
						{
								// we have valid data, no dupe
								
								if(isset($_POST['optionsCb']))
								{
									$cbOptions = $_POST['optionsCb'];
									$tmp = "";
									foreach($cbOptions as $opt)
									{
										$tmp .= $opt . ' ';
									}
								}
								
								$model->int_conquest_id = 0; // force always from here, source is non-conquest
								
								// set the source of prospect here, should be something to indicate it's a prospect

								$tmp = $tmp . ' : ' . $model->int_text;

								if(strlen($tmp) > 255) // get max length from the model if exists
									$tmp = substr($tmp,0,255); 
								$model->int_text = $tmp; 

								if(!$model->save())				// also updates active record with current record id, how nice!
									Yii::log("Can't Save Prospect Record to database",  CLogger::LEVEL_WARNING);

								$this->updateSessionInfo(self::CONFIRM_PAGE_ID, 
									array('lead_id'=>$model->int_id, 'make_id'=>$model->int_fabrikat, 'model_id'=>$model->int_modell, 
										  'trim_id'=>$model->int_ausstattung, 'color_id'=>$model->int_farbe)); 	// track 

								// at this point $model->int_id has the key for the inthae table inserts

								$dlr_id_list = array();
								$rank = 0;
								if(isset($_POST['Inthae']['special_dlrs']))
								{
									$sdl = $_POST['Inthae']['special_dlrs'];
									foreach($sdl as $dlr)
									{
										$prospect_sdlr = new Inthae;	
										$prospect_sdlr->ih_prospect_id = $model->int_id; 	// current models updated id
										$prospect_sdlr->ih_dealer_id = $dlr;
										$prospect_sdlr->ih_status = $rank++;				// database value for the order
										
										$dlr_id_list[] = $dlr; 								//	append to the list for later email
										
										if (!$prospect_sdlr->save()) 
											Yii::log("Can't Save Special Dealer Data to database",  CLogger::LEVEL_WARNING);
									}
								}

								// send thank you email, do this last after records are saved
								
								$color_name = $this->GetColorName($model->int_farbe);
										
								$img_name = self::DEFAULT_MAIL_CAR_IMAGE_PATH;	// car images are at web root, email is /webroot/carro/images/mail so back up the ladder
								
								if(($pic = $this->GetPic($model->int_ausstattung)) !== false)
									$img_name .= urldecode($pic['image_path']); 	// get the images path MUST NOT BE ENCODED as GetPic encodes!!!
								else
								{
									$pic = $this->getModelImage($model->int_modell);
									$img_name .= urldecode($pic['image_path']);
								}
										
								$this->SES_SendEmailAck($model->int_mail, 
											Yii::t('mail', 'Achacarro Confirmation Email'), 
											'mail_thanks', 
											array(
												'message' => Yii::t('LeadGen', 'One of the dealers within your neighborhood should contact you within 48 hours to give you great pricing on a car you are looking for.') .
												' ' . Yii::t('LeadGen', 'Achacarro is a transaction facilitator between buyers and dealerships and as such cannot be deemed responsible in case the selected dealerships do not contact or send a proposal to a buyer.'),
												'name' => ucfirst($model->int_vname), 
												'make_name' => $make_name,
												'model_name' => $model_name, 
												'color'=>$color_name, 
												'image'=>$img_name,
												'dlr_list'=>$dlr_id_list
											));
						}// dupe
						
						// kill any existing session and cookie and related
						// kill now, takes a refresh of the browser to remove the cookie
						// so after this remember we land on the confirm page and the cookie
						// and session should be deleted
						
						if(Yii::app()->session->isStarted) 
						{
							Yii::app()->session->clear();
							Yii::app()->session->destroy();
							Yii::app()->request->cookies->clear();
						}

						// $this->pageTitle = Yii::t('LeadGen', 'Thank you for your request');	// set the page title
					}
					else
					{
						// validation failed go back to the quote page and do it again

						// $this->updateSessionInfo(self::QUOTE_PAGE_ID); 	// track incoming
						
						$view = 'quote';	// fix up errors
					}
				}
				else // New user landing here, didn't come from quote page send to the landing page (landing.php)
					if(isset($_POST['conquest']))
					{
						// conquest does not mess with sessions, will not save it or update it

						$model = new LeadGen('quote');
						$save_model = new LeadGen('quote');
						$save_model = $model; // save a copy for later so we can mess with anything in the current model
						$this->checkPageState($model, array());
						$view = 'confirmation';		// jump to the confirmation page
						$model->skipConquest = true;	// we are just conquesting, so let confirmation page know not to do it again...
						
						// GET THE CONQUESTED VEHICLE INFO HERE

						if(!isset($_POST['cmake']) || !isset($_POST['cmodel']) || !isset($_POST['ctrim']) || !isset($_POST['cqid']) 
							|| !is_numeric($_POST['cmake']) || !is_numeric($_POST['cmodel']) || !is_numeric($_POST['ctrim']) || !is_numeric($_POST['cqid']))
						{
							Yii::log("Can't Save conquest record to database, invalid post data - Possible hacking",  CLogger::LEVEL_ERROR);
						}
						else
						{

							// save source make, model for the conquest record
							
							$make_name = $this->GetMakeName($model->int_fabrikat);
							$model_name = $this->GetModelName($model->int_modell);

							$model->int_text = $make_name . ' ' . $model_name . ' - ' . Yii::t('LeadGen','ADDED BY CONQUEST');

							$model->int_fabrikat = $_POST['cmake'];
							$model->int_modell = $_POST['cmodel'];
							$model->int_ausstattung = $_POST['ctrim'];
							$model->int_conquest_id = $_POST['cqid'];
							$model->int_farbe = -1;
							
							// save all needed conquest info for the landing page
							
							$model->conquest_campaign = $model->int_conquest_id;
							$model->conquest_make = $model->int_fabrikat;
							$model->conquest_model = $model->int_modell;
							$model->conquest_trim = $model->int_ausstattung;
							$model->conquest_confirm = true;
							
							if($model->validate())	
							{
								// also dupe check the conquest
								
								if(!$this->ProspectDupeCheck($model->int_mail, $model->int_fabrikat, $model->int_modell))
								{	
									$model->setIsNewRecord(true); 	// just to be sure. I think new model defaults to NEW record

									// set the source of prospect here, should be something to indicate it's a conquest
									
									if(!$model->save())				// also updates active record with current record id, how nice!
										Yii::log("Can't Save Conquest Record to database",  CLogger::LEVEL_ERROR);
										
									// get the closest dealer and stuff into the list
									
									$dealer = $this->GetNearestDealer($model->int_fabrikat, $model->int_plz, 1000, 1);
									
									if(empty($dealer))
										$dealer_id = 0;	// error no dealer to pic
									else
										$dealer_id = $dealer[0]['hd_id'];
										
									$prospect_conq = new Inthae;	
									$prospect_conq->ih_prospect_id = $model->int_id; 	// current models updated id
									$prospect_conq->ih_dealer_id = $dealer_id;
									$prospect_conq->ih_status = 0;						// database value for the order
										
									if (!$prospect_conq->save()) 
										Yii::log("Can't Save Conquest Dealer Data to database",  CLogger::LEVEL_ERROR);
								}
								$this->checkPageState($save_model, array());
							}
							else
								Yii::log("Invalid Conquest Record, Can't save it to the database",  CLogger::LEVEL_ERROR);
						}
					}
					else
					{
						// yii will start a new session from here 
						
						$this->updateSessionInfo(self::LANDING_PAGE_ID); 	// track incoming
						$model = new LeadGen('landing');

						// wipe out make model trim, leave the rest
						
						$this->checkPageState($model, array('int_fabrikat' => '', 'int_modell' => '', 'int_ausstattung' => ''));

						// stuff the models fields (which will update when the form is displayed)
						
						if(isset($_GET['make'])) 
						{
							$model->int_fabrikat = $_GET['make'];

							if(isset($_GET['model'])) 
								$model->int_modell = $_GET['model'];
						}

						// set page title from validated make/model fields uses get params for text names
						
						if(isset($_GET['make_name'])) 
						{
							$make_name = $_GET['make_name'];
							$model_name = '';
						
							if(isset($_GET['model_name'])) 
								$model_name = $_GET['model_name'];
								
							$this->pageTitle = $make_name . ' ' . $model_name . ' ' . Yii::t('LeadGen', 'Get Free New Car Quote');
						}
						else
							$this->pageTitle = Yii::t('LeadGen', 'Get Free New Car Quote');	// default

						$view = 'landing';
						$model->scenario = 'landing';	// set validation scenario to landing page 
					}//fresh user


		// hack to make browser back button work by enabling the page to be cached
		// otherwise you get the dreaded 'Re-send data popup'
		// this can cause odd side effects with logging and the views javascript code...
		
		$expires = 300;  // in secs
		header("Content-Type: text/html; charset: UTF-8");
		header("Cache-Control: max-age={$expires}");
		header("Pragma: ");
		header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . ' GMT');
    
		$this->render($view, array('model'=>$model));	// render correct view with current model state
	}

	/**
	* Helper function to just quickly log info to the session table.
	* This will use the current requestURL and sessionID for tracking.
	*
	* In this incarnation it will only update a single record with
	* the matching sessionID. If the id doesn't exist it will create and
	* set the needed params then save as a new record. This can lead to false
	* data and less then accurate reporting since ONLY ONE record will exist
	* for any session, and sessions don't go away until the browser is typically
	* closed and it expires.
	*  
	* $page_id -  integer page id to mark the page
	* $data - Optional array with the following format-
	* 	Array('lead_id' => 9088, 'make_id'=> 123, 'model_id'=> 456, 'trim_id' => 987, 'color_id' => -1)
	*
	* Note that it will only look at set elements, so if you only have make_id in the
	* array that is OK, it will only use what is defined or none if not set
	*
	* Last Note / Hack when the page id is set to the CONFIRM_PAGE_ID it sets the sess_step4 
	* value to 1 since that indicates in the current system that a page was submitted.
	*/
	
	public function updateSessionInfo($page_id, $data=null)
	{
		if(!is_numeric($page_id))
		{
			Yii::log("Invalid page_id, can't update session table",  CLogger::LEVEL_WARNING);
			return;
		}
		
		$sess_id = Yii::app()->session->sessionID;	// session ID (max size 32 - look in db)

		if(empty($sess_id))
		{
			Yii::log("Invalid session_id, can't update session table",  CLogger::LEVEL_WARNING);
			return;
		}

		$sessionTime = Yii::app()->session['sess_time'];

		// if session time is empty then we have a NEW session (or something really wrong!)
		
		if(empty($sessionTime))
		{
			$sessionTime = date('Y-m-d H:i:s');
			Yii::app()->session['sess_time'] =  $sessionTime;	// save to the session which should be valid!
			$sess = null;
		}
		else
		{
			// see if the session exists, note its a composite pri key of session id and session time
			// no session then still need to create
		
			$sess = Session::model()->findByPk(array('sess_id'=>$sess_id, 'sess_datum' => $sessionTime));
		}
		
		if($sess === null) // if null must be a new record, so create the rec
		{
			// new record to be created

			$sess = new Session;								// db model not a html session
			$sess->sess_url = Yii::app()->request->url;			// complete url logged
			$sess->sess_id = $sess_id;
			$sess->sess_datum = $sessionTime;
		}
		
		/*
		* update the page_id, either case (new/update) should have all other fields stuffed here as well
		*/

		if(is_array($data))
		{
			// may not have all of these at once, so stuff as they exist

			if(isset($data['lead_id']))
				$sess->sess_int_id = $data['lead_id'];
			
			if(isset($data['make_id']))
				$sess->sess_fab_id = $data['make_id'];
				
			if(isset($data['model_id']))
				$sess->sess_mod_id = $data['model_id'];
				
			if(isset($data['trim_id']))
				$sess->sess_aus_id = $data['trim_id'];
				
			if(isset($data['color_id']))
				$sess->sess_farb_id = $data['color_id'];
		}

		/*
		* Hack to stuff the current session with a complete marker in sess_step4
		* which the admin uses as a complete
		*/
		
		if($page_id == self::CONFIRM_PAGE_ID)
			$sess->sess_step4 = 1;
		
		if(!$sess->save()) 
			Yii::log("Can't Save Session Data to database",  CLogger::LEVEL_WARNING);
	}
	
	/**
	* @return array action filters
	* sjg - needs some work. No delete ever needed, not using access control or crud stuff
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
		* Only allow the 3 pages and the lookup and ajax related functions to be accessable
		*/
		
		return array(
			array('allow',  // allow all to look at the pages and lookups
				'actions'=>array('landing', 'quote', 'confirmation', 
				'models', 'colors', 'dealers', 'cities', 'error', 'postalcode', 
				'photomakes', 'photomodel', 'phototrim', 'homepagephotos', 'makelogoimage'),  // added create to all users no login needed 
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
	*
	* $data is the current forms state that is going to be set to the $model's attributes (form fields)
	* and finally set the current page state to the controllers internal state
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
