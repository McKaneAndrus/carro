<?php
/**
 * @link    https://github.com/igorsantos07/yii-br-validator
 * @license https://github.com/igorsantos07/yii-br-validator/blob/master/LICENSE
 */

/**
 * PhoneValidator checks if the attribute value is a valid brazilian phone number.
 *
 * @author Igor Santos <igorsantos07@gmail.com>
 */
class PhoneValidator extends CValidator {

	const TYPE_LANDLINE = 'landline';

	const TYPE_CELLPHONE = 'cellphone';

	const TYPE_BOTH = 'both';

	public $allowEmpty;

/*	public $ninthDigitMessage = 'Falta o nono dígito no {attribute}.';

	public $lengthMessage = '{attribute} de tamanho inválido.';

	public $areaMessage = 'Código de área inválido no {attribute}.';
*/
	// Shorter messages
	
	public $ninthDigitMessage = 'Falta o nono dígito';

	public $lengthMessage = 'Tamanho inválido.';

	public $areaMessage = 'Código de área inválido';
	
	public $invalidMessage = 'Número de telefone inválido';

	/**
	 * If it should validate only cellphones, landlines, or both are okay.
	 * Should use one of PhoneValidator::TYPE_* constants.
	 * @var string
	 */
	public $type = self::TYPE_BOTH;

	/**
	 * If true will also validate with the area code in the attribute. Defaults to false.
	 * @see $areaCodeField
	 * @var bool
	 */
	public $areaCode = false;

	/**
	 * If set, will use the given attribute name as area code to validate cellphones.
	 * @var string
	 */
	public $areaCodeAttribute;

	/**
	 * Landline numbers begin with this list of digits.
	 * @var array
	 */
	public $landlineBegin = array(2, 3, 4, 5);

	/**
	 * Cellphone numbers begin with this list of digits.
	 * @var array
	 */
	public $cellphoneBegin = array(6, 7, 8, 9);

	/**
	 * Cellphone numbers that require 9 digits begin with this list of digits.
	 * @see $ninthDigitAreaCodes
	 * @var array
	 */
	public $cellphoneNinthDigitBegin = array(8, 9);

	/**
	 * List of area codes that require 9 digits on the cellphone. Should be updated from time to time.
	 * @link http://portal.embratel.com.br/embratel/9-digito/
	 * @see  $cellphoneNinthDigitBegin
	 *
	 * !!!!NOTE THESE ARE CHANGING AND ARE NOT COMPLETE. LIKELY REMOVE THIS TEST!!!
	 */
	public $ninthDigitAreaCodes = array(
		11, 12, 13, 14, 15, 16, 17, 18, 19,
		21, 22, 24, 27, 28,
	);

	// new table of ddd codes
	// updated 08/11/2014. Includes reserved codes
	// this table can be used to make much tighter on DDD if required, but
	// would require an update if new one are added
	
	/*
	public $validDDD = array(
		11, 12, 13, 14, 15, 16, 17, 18, 19,
		21, 22, 23, 24, 25, 26,
		27, 28,
		31, 32, 33, 34, 35, 36, 37, 38, 39,
		41, 42, 43, 44, 45, 46,
		47, 48, 49,
		51, 52, 53, 54, 55, 56, 57, 58, 59,
		61, 62, 63, 65, 66, 67, 68, 69,
		71, 72, 73, 74, 75, 76, 77, 78,
		79,
		81, 82, 83, 84, 85, 86, 87, 88, 89,
		91, 92, 93, 94, 95, 96, 97, 98, 99
	);
	*/

	/**
	 * Temp area for found errors in sub-validation methods.
	 * @var array
	 */
	protected $errors = array();

	public function __construct() {
		if ($this->message === null) {
			$this->message = Yii::t('yii', '{attribute} is invalid.');
		}
	}

	/**
	 * @inheritdoc
	 */
	protected function validateAttribute($object, $attribute) {
		if (!$object->$attribute && $this->allowEmpty)
			return;

		if (!in_array($this->type, array(self::TYPE_BOTH, self::TYPE_CELLPHONE, self::TYPE_LANDLINE)))
			throw new CException('Validator expects "type" property to be one of PhoneValidator::TYPE_* constants');

		$number = preg_replace('/[^0-9_]/', '', $object->$attribute);


		// Added this check which can reject some numbers like all the same digit in DDD and  8 or 9 phone number length. DDD is checked
		// This has the possibility of REJECTING 20 numbers so of them are invalid, but some are not. Don't make me spell it out...
		
        for($x=0; $x < 10; $x++)
        {
            if($number == str_repeat($x, 10) ||  $number == str_repeat($x, 11))	// could be a more efficient way, but too lazy
            {
				$this->addError($object, $attribute, $this->invalidMessage);
				return false;
			}
		}
                
		if ($this->areaCode) {
			$area   = substr($number, 0, 2);
			$number = substr($number, 2);
		}
		elseif ($this->areaCodeAttribute) 
		{
			$area = $object->{$this->areaCodeAttribute};
		}
		else 
		{
			$area = null;
		}

		if ($area && (strlen($area) != 2 || $area < 11))
			$this->addError($object, $attribute, $this->areaMessage);


		if (!$this->{'validate'.ucfirst($this->type)}($area, $number)) 
		{
			$total = sizeof($this->errors);
			for ($i = 0; $i < $total; $i++)
				$this->addError($object, $attribute, Yii::t('yii', array_shift($this->errors)));
		}
	}

	protected function validateLandline($area, $number) {
		if (strlen($number) != 8) {
			$this->errors[] = $this->lengthMessage;
			return false;
		}

		if (!in_array($number[0], $this->landlineBegin)) {
			$this->errors[] = $this->message;
			return false;
		}
		return true;
	}

	/*
	* Cell number validator Modifed to be much looser and safer for accepting number that 
	* are valid but may change to pending cell number changes (yes, still hapenning 2014)
	*
	* This function is much simplified to only validate the length of digits. 
	* and the first digit of a 9 digit cell number which must be 9
	*
	*/

	protected function validateCellphone($area, $number) 
	{
		$len = strlen($number);

		if(!($len == 8 || $len == 9))			// all phones are 8 or 9 digits
		{
			$this->errors[] = $this->lengthMessage;
			return false;
		}
		
		if($len == 9 &&  $number[0] != 9)	// all cells with 9 digits begin with 9
		{
			$this->errors[] = $this->ninthDigitMessage;
			return false;
		}
		
		return true;
	}


	protected function validateBoth($area, $number) {
		if ($this->validateLandline($area, $number)) {
			return true;
		}
		else{
			$landline_errors = $this->errors;
			$this->errors = array();
			$valid_cellphone = $this->validateCellphone($area, $number);
			
			if (!$valid_cellphone) {
				foreach($landline_errors as $error) {
					if (!in_array($error, $this->errors))
						$this->errors[] = $error;
				}
			}
		}
	}
}
