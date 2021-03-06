<?


class ConfigureController extends Controller{


    public $layout='//layouts/config';
    public function filters()
    {
        return array(
            'accessControl',
            'postOnly + delete',
        );
    }


    public function actionIndex(){
        $model = Yii::app()->db->CreateCommand()
            ->select()
            ->from("license")
            ->where("progType = 'kafe'")
            ->queryRow();
        $this->render("index",array(
            'model'=>$model
        ));
    }

    public function actionActive(){
        $func = new Functions();
        if(isset($_POST["placeName"])) {
            $SN = $func->UniqueMachineID("C");
            $hash = $func->GetHash($_POST["placeName"],$_POST["secretKey"],$SN);
            $_POST["prog_type"] = 'waiter';
            $_POST["SN"] = $SN;
            $_POST["hash"] = $hash;
            $this->render("active",[
                'data' => $_POST
            ]);
        }
        else{
            $this->redirect("/config/index");
        }
    }

    public function actionSaveActive(){
        Yii::app()->db->createCommand()
            ->insert("license",[
                'progType' => $_POST["prog_type"],
                'hash' => $_POST["hash"],
                'secretKey' => $_POST["secretKey"],
                'registerDate' => date("Y-m-d H:i:s"),
                'active' => 1,
                'licenseId' => $_POST["licenseId"]
            ]);

    }


}