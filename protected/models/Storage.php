<?php

/**
 * This is the model class for table "storage".
 *
 * The followings are the available columns in table 'storage':
 * @property integer $storage_id
 * @property string $curDate
 * @property integer $prod_id
 * @property double $curCount
 */
class Storage extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'storage';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('prod_id, price', 'numerical', 'integerOnly'=>true),
			array('curCount', 'numerical'),
			array('curDate', 'safe'),
			/*
			//Example username
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u',
                 'message'=>'Username can contain only alphanumeric 
                             characters and hyphens(-).'),
          	array('username','unique'),
          	*/
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('storage_id, curDate, prod_id, curCount, price', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'product'=>array(self::BELONGS_TO,'Products','prod_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'storage_id' => 'Код',
			'curDate' => 'Дата',
			'prod_id' => 'Название продукта',
			'curCount' => 'Количество',
            'price' => 'Цена',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('storage_id',$this->storage_id);
		$criteria->compare('curDate',$this->curDate,true);
		$criteria->compare('prod_id',$this->prod_id);
		$criteria->compare('curCount',$this->curCount);
        $criteria->compare('price',$this->price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Storage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeSave() 
    {
        $userId=0;
		if(null!=Yii::app()->user->id) $userId=(int)Yii::app()->user->id;
		
		if($this->isNewRecord)
        {           
                        						
        }else{
                        						
        }

        
        	// NOT SURE RUN PLEASE HELP ME -> 
        	//$from=DateTime::createFromFormat('d/m/Y',$this->curDate);
        	//$this->curDate=$from->format('Y-m-d');
        	
        return parent::beforeSave();
    }

    public function beforeDelete () {
		$userId=0;
		if(null!=Yii::app()->user->id) $userId=(int)Yii::app()->user->id;
                                
        return false;
    }

    public function afterFind()    {
         
        	// NOT SURE RUN PLEASE HELP ME -> 
        	//$from=DateTime::createFromFormat('Y-m-d',$this->curDate);
        	//$this->curDate=$from->format('d/m/Y');
        	
        parent::afterFind();
    }
	
		
	public function defaultScope()
    {
    	/*
    	//Example Scope
    	return array(
	        'condition'=>"deleted IS NULL ",
            'order'=>'create_time DESC',
            'limit'=>5,
        );
        */
        $scope=array();

        
        return $scope;
    }



    public function addToStorage($prodId,$cnt){
        $model = Yii::app()->db->createCommand()
            ->select()
            ->from("storage")
            ->where("prod_id = :id",array(":id"=>$prodId))
            ->queryRow();
        if(!empty($model)){
            Yii::app()->db->createCommand()->update("storage",array(
                "cnt" => $model["cnt"] + $cnt
            ),"prod_id = :id",array(":id"=>$prodId));
        }
        else{
            Yii::app()->db->createCommand()->insert("storage",array(
                "cnt" => $cnt,
                "prod_id" => $prodId
            ));
        }
    }

    public function removeToStorage($prodId,$cnt){
        $model = Yii::app()->db->createCommand()
            ->select()
            ->from("storage")
            ->where("prod_id = :id",array(":id"=>$prodId))
            ->queryRow();
        if(!empty($model)){
            Yii::app()->db->createCommand()->update("storage",array(
                "cnt" => $model["cnt"] - $cnt
            ),"prod_id = :id",array(":id"=>$prodId));
        }
        else{
            Yii::app()->db->createCommand()->insert("storage",array(
                "cnt" => (-1)*$cnt,
                "prod_id" => $prodId
            ));
        }
    }

    public function addToStorageDep($prodId,$cnt,$type,$depId){
        $model = Yii::app()->db->createCommand()
            ->select()
            ->from("storage_dep")
            ->where("prod_id = :id AND prod_type = :t AND department_id = :depId",array(":id"=>$prodId,":t"=>$type,":depId"=>$depId))
            ->queryRow();
        if(!empty($model)){
            Yii::app()->db->createCommand()->update("storage_dep",array(
                "cnt" => $model["cnt"] + $cnt
            ),"prod_id = :id AND prod_type = :t AND department_id = :depId",array(":id"=>$prodId,":t"=>$type,":depId"=>$depId));
        }
        else{
            Yii::app()->db->createCommand()->insert("storage_dep",array(
                "cnt" => $cnt,
                "prod_id" => $prodId,
                "prod_type" => $type,
                "department_id" => $depId
            ));
        }
    }

    public function removeToStorageDep($prodId,$cnt,$type,$depId){
        $model = Yii::app()->db->createCommand()
            ->select()
            ->from("storage_dep")
            ->where("prod_id = :id AND prod_type = :t AND department_id = :depId",array(":id"=>$prodId,":t"=>$type,":depId"=>$depId))
            ->queryRow();
        if(!empty($model)){
            Yii::app()->db->createCommand()->update("storage_dep",array(
                "cnt" => $model["cnt"] - $cnt
            ),"prod_id = :id AND prod_type = :t AND department_id = :depId",array(":id"=>$prodId,":t"=>$type,":depId"=>$depId));
        }
        else{
            Yii::app()->db->createCommand()->insert("storage_dep",array(
                "cnt" => (-1)*$cnt,
                "prod_id" => $prodId,
                "prod_type" => $type,
                "department_id" => $depId
            ));
        }
    }
}
