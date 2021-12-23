<?



class SetupController extends Controller{
    
    public function __construct($id, $module = null)
    {   
//         $res = Yii::app()->db->CreateCommand()
//             ->select()
//             ->from("license")
//             ->where("progType = 'waiter' and active = 1")
//             ->queryRow();
//         if(!empty($res)){
// //            echo "<pre>";
// //            print_r("some");
// //            echo "</pre>";
//             $name = Yii::app()->config->get("name");
//             $func = new Functions();
//             $SN = $func->UniqueMachineID("C");
//             $hash = $func->GetHash($name,$res["secretKey"],$SN);
//             if($res["hash"] != $hash){
//                 $this->redirect("/configure/index");
//             }
//         }
//         else{
//             $this->redirect("/configure/index");
//         }
        parent::__construct($id, $module);
    }

}