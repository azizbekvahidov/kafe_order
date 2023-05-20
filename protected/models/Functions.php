<?
require_once Yii::app()->basePath . '/library/printer/autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
class Functions {
    public function UniqueMachineID($drive) {
//        $drive = shell_exec("wmic diskdrive get serialnumber");
//
//        $lines = explode("\n",$drive);
//        $result = $lines[1]." ".$lines[2];
        if (preg_match('#Volume Serial Number is (.*)\n#i',shell_exec('dir '.$drive.':'), $m)) {
            $volname = ' ('.$m[1].')';
        } else {
            $volname = '';
        }
        $result = $volname;
        return $result;
    }

    public function GetHash($placeName,$secretKey,$sn){
        return sha1($placeName.$secretKey.md5($sn));
    }
    public $recurseLimit = 1;
    public function multToSumProd($array,$dates){
        $result = array();
        $prod = new Products();
        if(!empty($array))
            foreach ($array as $key => $val) {
                $result[$key] = $prod->getCostPrice($key,$dates)*$val;
            }
        return array_sum($result);
    }

    public function multToSumStuff($array,$dates){
        $result = array();
        $stuff = new Halfstaff();
        if(!empty($array))
            foreach ($array as $key => $val) {
                $result[$key] = $stuff->getCostPrice($key,$dates)*$val;
            }
        return array_sum($result);
    }

    public function changeToFloat($number){
        $ss = $number;
        $arr = NULL;
        $arr = str_split($ss);
        $k = 0;
        while($k != strlen($ss))
        {
            if ($arr[$k] == ',')
                $arr[$k] = '.';
            $k++;
        }
        $ss = implode($arr);
        return $ss;
    }

    public function getAddProduct($orderId){
        $model = Yii::app()->db->createCommand()
            ->select('sum(count) as count')
            ->from('orderRefuse')
            ->where('order_id = :id AND add = 1',array(':id'=>$orderId))
            ->group('order_id')
            ->queryRow();
        return (!empty($model['count'])) ? $model['count'] : 0;
    }
    public function getRefuseProduct($orderId){
        $model = Yii::app()->db->createCommand()
            ->select('sum(count) as count')
            ->from('orderRefuse')
            ->where('order_id = :id AND add = 0',array(':id'=>$orderId))
            ->group('order_id')
            ->queryRow();
        return (!empty($model['count'])) ? $model['count'] : 0;
    }

    public function getExpenseCostPrice($id,$dates){
        $summ = 0;
        $dish = new Dishes();
        $stuff = new Halfstaff();
        $prod = new Products();
        $model = Yii::app()->db->createCommand()
            ->select('ord.just_id, ord.order_id, ord.count')
            ->from('expense ex')
            ->join('orders ord','ord.expense_id = ex.expense_id')
            ->where('ex.expense_id = :id AND ord.type = :types AND ord.deleted != 1',array(':id'=>$id,':types'=>1))
            ->queryAll();
        $model2 = Yii::app()->db->createCommand()
            ->select('ord.just_id, ord.order_id, ord.count')
            ->from('expense ex')
            ->join('orders ord','ord.expense_id = ex.expense_id')
            ->where('ex.expense_id = :id AND ord.type = :types AND ord.deleted != 1',array(':id'=>$id,':types'=>2))
            ->queryAll();
        $model3 = Yii::app()->db->createCommand()
            ->select('ord.just_id, ord.order_id, ord.count')
            ->from('expense ex')
            ->join('orders ord','ord.expense_id = ex.expense_id')
            ->where('ex.expense_id = :id AND ord.type = :types AND ord.deleted != 1',array(':id'=>$id,':types'=>3))
            ->queryAll();

        foreach ($model as $val) {
            $temp = $dish->getCostPrice($val['just_id'],$dates)*$val['count'];
            $summ = $summ + $temp;
            Yii::app()->db->createCommand()->update('orders',array('costPrice'=>$temp),'order_id = :id',array(':id'=>$val['order_id']));
        }

        foreach ($model2 as $val) {
            $temp = $stuff->getCostPrice($val['just_id'],$dates)*$val['count'];
            $summ = $summ + $temp;
            Yii::app()->db->createCommand()->update('orders',array('costPrice'=>$temp),'order_id = :id',array(':id'=>$val['order_id']));
        }

        foreach ($model3 as $val) {
            $temp = $prod->getCostPrice($val['just_id'],$dates)*$val['count'];
            $summ = $summ + $temp;
            Yii::app()->db->createCommand()->update('orders',array('costPrice'=>$temp),'order_id = :id',array(':id'=>$val['order_id']));
        }
        Yii::app()->db->createCommand()->update('expense',array('costPrice'=>$summ),'expense_id = :id',array(':id'=>$id));
        return $summ;
    }
    public function getDish($id,$action,$expId){
        try {
            if ($id != null||$id != "") {
                $model=Yii::app()->db->createCommand()
                    ->select('d.name as dName, dep.name as depName, dep.printer as printer')
                    ->from('dishes d')
                    ->join('department dep', 'dep.department_id = d.department_id')
                    ->where('d.dish_id = :id', array(':id'=>$id))
                    ->queryRow();
                if ($model['printer'] != null||$model['printer'] != "") {
                    return $model;
                } else {
                    Yii::app()->db->createCommand()->insert("logs", array(
                        "log_date"=>date("Y-m-d H:i:s"),
                        "actions"=>"dishPrintSelect",
                        "table_name"=>"",
                        "curId"=>$id,
                        "message"=>$action."=>".$expId." No Printer name",
                        "count"=>0
                    ));
                    return 0;
                }
            } else {
                Yii::app()->db->createCommand()->insert("logs", array(
                    "log_date"=>date("Y-m-d H:i:s"),
                    "actions"=>"dishPrintSelect",
                    "table_name"=>"",
                    "curId"=>$id,
                    "message"=>$action."=>".$expId." No dishId",
                    "count"=>0
                ));
                return 0;
            }
        }
        catch (Exception $ex){
            Yii::app()->db->createCommand()->insert("logs", array(
                "log_date"=>date("Y-m-d H:i:s"),
                "actions"=>"dishPrintSelectException",
                "table_name"=>"",
                "curId"=>$id,
                "message"=>$action."=>".$expId." ".$ex->getMessage(),
                "count"=>0
            ));
        }
    }

    public function getStuff($id,$action,$expId){
        try{
            if($id != null || $id != "") {
                $model = Yii::app()->db->createCommand()
                    ->select('h.name as dName, dep.name as depName, dep.printer as printer')
                    ->from('halfstaff h')
                    ->join('department dep','dep.department_id = h.department_id')
                    ->where('h.halfstuff_id = :id',array(':id'=>$id))
                    ->queryRow();
                if ($model['printer'] != null||$model['printer'] != "") {
                    return $model;
                } else {
                    Yii::app()->db->createCommand()->insert("logs", array(
                        "log_date"=>date("Y-m-d H:i:s"),
                        "actions"=>"stuffPrintSelect",
                        "table_name"=>"",
                        "curId"=>$id,
                        "message"=>$action."=>".$expId." No Printer name",
                        "count"=>0
                    ));
                    return 0;
                }
            }
            else{
                Yii::app()->db->createCommand()->insert("logs", array(
                    "log_date"=>date("Y-m-d H:i:s"),
                    "actions"=>"stuffPrintSelect",
                    "table_name"=>"",
                    "curId"=>$id,
                    "message"=>$action."=>".$expId." No stuffId",
                    "count"=>0
                ));
                return 0;
            }
        }
        catch (Exception $ex){
            Yii::app()->db->createCommand()->insert("logs", array(
                "log_date"=>date("Y-m-d H:i:s"),
                "actions"=>"stuffPrintSelectException",
                "table_name"=>"",
                "curId"=>$id,
                "message"=>$action."=>".$expId." ".$ex->getMessage(),
                "count"=>0
            ));
        }
    }

    public function getProd($id,$action,$expId){
        try {
            if ($id != null||$id != "") {
                $model=Yii::app()->db->createCommand()
                    ->select('p.name as dName, dep.name as depName, dep.printer as printer')
                    ->from('products p')
                    ->join('department dep', 'dep.department_id = p.department_id')
                    ->where('p.product_id = :id', array(':id'=>$id))
                    ->queryRow();
                if ($model['printer'] != null||$model['printer'] != "") {
                    return $model;
                } else {
                    Yii::app()->db->createCommand()->insert("logs", array(
                        "log_date"=>date("Y-m-d H:i:s"),
                        "actions"=>"prodPrintSelect",
                        "table_name"=>"",
                        "curId"=>$id,
                        "message"=>$action."=>".$expId." No Printer name",
                        "count"=>0
                    ));
                    return 0;
                }
            } else {
                Yii::app()->db->createCommand()->insert("logs", array(
                    "log_date"=>date("Y-m-d H:i:s"),
                    "actions"=>"prodPrintSelect",
                    "table_name"=>"",
                    "curId"=>$id,
                    "message"=>$action."=>".$expId." No prodId",
                    "count"=>0
                ));
                return 0;
            }
        }
        catch (Exception $ex){
            Yii::app()->db->createCommand()->insert("logs", array(
                "log_date"=>date("Y-m-d H:i:s"),
                "actions"=>"prodPrintSelectException",
                "table_name"=>"",
                "curId"=>$id,
                "message"=>$action."=>".$expId." ".$ex->getMessage(),
                "count"=>0
            ));
        }
    }


    public function PrintCheck($expId,$action,$id,$user,$count,$table,$comment){
        
                $result = array();
      $depId = array();
      $archive = new ArchiveOrder();
        $comments = array();
      $resultArchive = array();
      $user = Yii::app()->db->createCommand()
          ->select('')
          ->from('employee e')
          ->where('e.employee_id = :id',array(':id'=>$user))
          ->queryRow();
      if($action == 'create'){
          if(!empty($id))
              foreach ($id as $key => $val) {
                  $expl = explode('_',$val);
                  if($expl[0] == 'dish') {
                      $model = $this->getDish($expl[1],$action,$expId);
                      if($model != 0) {
                          $result[$model['depName']][$model['dName']]=$count[$key];
                          $comments[$model['depName']][$model['dName']]=$comment[$key];
                          $print[$model['depName']]=$model['printer'];
                      }
                  }
                  if($expl[0] == 'stuff'){
                      $model = $this->getStuff($expl[1],$action,$expId);
                      if($model != 0) {
                          $result[$model['depName']][$model['dName']]=$count[$key];
                          $comments[$model['depName']][$model['dName']]=$comment[$key];
                          $print[$model['depName']]=$model['printer'];
                      }
                  }
                  if($expl[0] == 'product'){
                      $model = $this->getProd($expl[1],$action,$expId);
                      if($model != 0) {
                          $result[$model['depName']][$model['dName']]=$count[$key];
                          $comments[$model['depName']][$model['dName']]=$comment[$key];
                          $print[$model['depName']]=$model['printer'];
                      }
                  }
              }
      }
      if($action == 'update'){
          $archive = Yii::app()->db->createCommand()
              ->select('')
              ->from('archiveorder ao')
              ->where('ao.expense_id = :id AND archive_action != "print"',array(':id'=>$expId))
              ->order('ao.archive_date DESC')
              ->limit(1,1)
              ->queryRow();
          if(!empty($archive)) {
              $temp=explode('*', $archive['archive_message']);
              foreach ($temp as $key=>$value) {
                  $temporary=explode('=>', $value);

                  if ($temporary[0] == 'dish') {
                      $dishes=explode(',', $temporary[1]);
                      foreach ($dishes as $val) {
                          if($val != "") {
                              $core=explode(':', $val);
                              $model=$this->getDish($val, $action, $expId);
                              if ($model != 0) {
                                  $resultArchive[$model['depName']][$model['dName']]=$core[1];
                                  $print[$model['depName']]=$model['printer'];
                              }
                          }
                      }
                  }
                  if ($temporary[0] == 'stuff') {
                      $dishes=explode(',', $temporary[1]);
                      foreach ($dishes as $val) {
                          if($val != "") {
                              $core=explode(':', $val);
                              $model=$this->getStuff($val, $action, $expId);
                              if ($model != 0) {
                                  $resultArchive[$model['depName']][$model['dName']]=$core[1];
                                  $print[$model['depName']]=$model['printer'];
                              }
                          }
                      }
                  }
                  if ($temporary[0] == 'prod') {
                      $dishes=explode(',', $temporary[1]);
                      foreach ($dishes as $val) {
                          if($val != "") {
                              $core=explode(':', $val);
                              $model=$this->getProd($val, $action, $expId);
                              if ($model != 0) {
                                  $resultArchive[$model['depName']][$model['dName']]=$core[1];
                                  $print[$model['depName']]=$model['printer'];
                              }
                          }
                      }
                  }
              }
          }
          if(!empty($id)){
            
              foreach ($id as $key => $val) {
                  $expl = explode('_',$val);
                  switch ($expl[0]){    
                      case "dish":
                          $model = $this->getDish($expl[1],$action,$expId);
                          if($model != 0) {
                              $result[$model['depName']][$model['dName']]=$count[$key];
                              $comments[$model['depName']][$model['dName']]=$comment[$key];
                              $print[$model['depName']]=$model['printer'];
                          }
                          break;
                      case 'stuff':
                          $model = $this->getStuff($expl[1],$action,$expId);
                          if($model != 0) {
                              $result[$model['depName']][$model['dName']]=$count[$key];
                              $comments[$model['depName']][$model['dName']]=$comment[$key];
                              $print[$model['depName']]=$model['printer'];
                          }
                          break;
                      case 'product':
                          $model = $this->getProd($expl[1],$action,$expId);
                          if($model != 0) {
                              $result[$model['depName']][$model['dName']]=$count[$key];
                              $comments[$model['depName']][$model['dName']]=$comment[$key];
                              $print[$model['depName']]=$model['printer'];
                          }
                          break;
                  }
              }
            }
              
              
          $result = $this->ShowChange($result,$resultArchive);
      }
      foreach($result as $key => $val) {

          $date=date("Y-m-d H:i:s");
          $this->PrintChecks($print,$val,$user,$table,$key,$date, $this->recurseLimit,$comments[$key]);

      }

    }
    public function PrintChecks($print,$val,$user,$table,$key,$date, $limit,$comment){
        try {
                        
            if (!empty($print[$key])) {
//                $profile = CapabilityProfile::load("simple");
                //              $connector = new NetworkPrintConnector("XP-58", 9100);
                if(Yii::app()->config->get("printer_interface") == "usb")
                    $connector = new WindowsPrintConnector($print[$key]);
                if(Yii::app()->config->get("printer_interface") == "ethernet")
                    $connector=new NetworkPrintConnector($print[$key],9100);
                $printer=new Printer($connector);
            

            //          $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->setTextSize(2, 2);
            $printer->text($key . "\n\n");
            $printer->selectPrintMode();

            $printer->setTextSize(1, 1);
            foreach ($val as $keys=>$value) {
                // Yii::app()->db->createCommand()->insert("printdetail", array(
                //     'name'=>$keys,
                //     'cnt'=>$value,
                //     'printId'=>$lastId,
                // ));
                $order = new item($keys, $value);
                $printer -> text($order);
                if(isset($comment[$keys]) && $comment[$keys] != "") {
                    $printer->text($comment[$keys]);
                }
                $printer->feed();
            }


            //          $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $footer = new item($user["name"],"стол " . $table);

            $printer->setTextSize(1, 1);
            $printer->text($footer);
            $printer->selectPrintMode();


            /* Footer */
            $printer->feed(1);
            $printer->text($date . "\n");
            //$printer->text("------------------" . "\n");
            $printer->feed(2);

            /* Cut the receipt and open the cash drawer */
            $printer->cut();
            $printer->pulse();
            $printer -> getPrintConnector() -> write(PRINTER::ESC . "B" . chr(4) . chr(1));
            $printer->close();
        } 
        else{
            
            Yii::app()->db->createCommand()->insert("logs", array(
                "log_date"=>date("Y-m-d H:i:s"),
                "actions"=>"printException",
                "table_name"=>"",
                "curId"=>0,
                "message"=>"Printer name is empty",
                "count"=>0
            ));
        }
        }
        catch (Exception $exception){
                        echo "<pre>";
                        print_r($exception->getMessage());
                        echo "</pre>";
            
               Yii::app()->db->createCommand()->insert("logs", array(
                   "log_date"=>date("Y-m-d H:i:s"),
                   "actions"=>"printException",
                   "table_name"=>"",
                   "curId"=>0,
                   "message"=>$exception->getMessage(),
                   "count"=>0
               ));
        }
    }

    public static function transliterate($textcyr = null, $textlat = null) {
        $cyr = array(
            'ё',  'ж',  'х',  'ц',  'ч',  'щ','ш',  'ъ',  'э',  'ю',  'я',  'а', 'б', 'в', 'г', 'д', 'е', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'ь','ы',
            'Ё',  'Ж',  'Х',  'Ц',  'Ч',  'Щ','Ш',  'Ъ',  'Э',  'Ю',  'Я',  'А', 'Б', 'В', 'Г', 'Д', 'Е', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Ь','Ы');
        $lat = array(
            'yo', 'j', 'x', 'ts', 'ch', 'sh', 'sh', '`', 'eh', 'yu', 'ya', 'a', 'b', 'v', 'g', 'd', 'e', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', '','i',
            'Yo', 'J', 'X', 'Ts', 'Ch', 'Sh', 'Sh', '`', 'Eh', 'Yu', 'Ya', 'A', 'B', 'V', 'G', 'D', 'E', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', '','I');
        if($textcyr)
            return str_replace($cyr, $lat, $textcyr);
        else if($textlat)
            return str_replace($lat, $cyr, $textlat);
        else
            return null;
    }

    public function ShowChange($array1,$array2){
        
        // echo "<pre>";
        // print_r($array1);
        // echo "</pre>";
        
        // echo "<pre>";
        // print_r($array2);
        // echo "</pre>";
        // die();
        $result=array();
        if(!empty($array2)) {
            foreach ($array1 as $key=>$value) {
                foreach ($value as $keys=>$val) {
                    if(isset($array2[$key][$keys])){
                    $temp=$val - $array2[$key][$keys];
                }
                else{
                    $temp = $val;
                }
                    if ($temp != 0) {
                        $result[$key][$keys]=$temp;
                    }
                }
            }
            foreach ($array2 as $key=>$value) {
                foreach ($value as $keys=>$val) {
                    if(isset($array1[$key][$keys])){
                        $temp=$val - $array2[$key][$keys];
                    }
                    else{
                        $temp = $val;
                    }
                    if ($temp != 0) {
                        $result[$key][$keys]=-$temp;
                    }
                }
            }
        }
        return $result;
    }

    public function PrintFinalCheck($exp){
        $percent = 0;
        $expense = Yii::app()->db->createCommand()
            ->select('')
            ->from('expense ex')
            ->join('employee emp','emp.employee_id = ex.employee_id')
            ->where('ex.expense_id = :id ',array(':id'=>$exp))
            ->queryRow();
        if($expense['check_percent'] != 0){
            $percent = 10;
        }
        else{
            $percent = 1;
        }
        $model = Expense::model()->with('order.dish')->findByPk($exp,('order.deleted != 1'));
        $model2 = Expense::model()->with('order.halfstuff')->findByPk($exp,('order.deleted != 1'));
        $model3 = Expense::model()->with('order.products')->findByPk($exp,('order.deleted != 1'));
    }

    public function testPrint(){
            //              $connector = new NetworkPrintConnector("XP-58", 9100);
        $items = array(
            new item("Example item #1", "4.00"),
            new item("Another thing", "3.50"),
            new item("Something else", "1.00"),
            new item("A final item", "4.45"),
        );
        $subtotal = new item('Subtotal', '12.95');
        $tax = new item('A local tax', '1.30');
        $total = new item('Total', '14.25');
        /* Date is kept the same for testing */
// $date = date('l jS \of F Y h:i:s A');
        $date = "Monday 6th of April 2015 02:56:25 PM";
        $connector = new WindowsPrintConnector("smb://Azizbek-PC/XP-80");
        $printer = new Printer($connector);


        /* Name of shop */
        $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer -> text("ExampleMart Ltd.\n");
        $printer -> selectPrintMode();
        $printer -> text("Shop No. 42.\n");
        $printer -> feed();

        /* Title of receipt */
        $printer -> setEmphasis(true);
        $printer -> text("SALES INVOICE\n");
        $printer -> setEmphasis(false);

        /* Items */
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> setEmphasis(true);
        $printer -> text(new item('', '$'));
        $printer -> setEmphasis(false);
        foreach ($items as $item) {
            $printer -> text($item);
        }
        $printer -> setEmphasis(true);
        $printer -> text($subtotal);
        $printer -> setEmphasis(false);
        $printer -> feed();

        /* Tax and total */
        $printer -> text($tax);
        $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer -> text($total);
        $printer -> selectPrintMode();

        /* Footer */
        $printer -> feed(2);
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("Thank you for shopping at ExampleMart\n");
        $printer -> text("For trading hours, please visit example.com\n");
        $printer -> feed(2);
        $printer -> text($date . "\n");

        /* Cut the receipt and open the cash drawer */
        $printer -> cut();
        $printer -> pulse();

        $printer -> close();
    }
}
class item
{
    private $name;
    private $price;
    private $dollarSign;

    public function __construct($name = '', $price = '', $dollarSign = false)
    {
        $this -> name = $name;
        $this -> price = $price;
        $this -> dollarSign = $dollarSign;
    }

    public function __toString()
    {
        $rightCols = 10;
        $leftCols = 30;
//        $rightCols = 10;
//        $leftCols = 38;
        if ($this -> dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this -> name, $leftCols) ;

        $sign = ($this -> dollarSign ? '$ ' : '');
        $right = str_pad($sign . $this -> price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right\n";
    }
}
