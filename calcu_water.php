<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="charge.css" />
  </head>
  <body>
    <?php

    //水量,メーター口径の受け取り
        $uAmount =$_POST['amount'];
        $dAmount =$_POST['amount'];
        $caliber =$_POST['caliber'];
    //還元率を変数で設定(還元割合が変わる場合はこちらの数値を変更)
        $rRatio = 0.9;

    //還元チェックの有無で上水の処理を場合分け
      if (isset($_POST['reduction'])){
        if($uAmount == null) {
          echo null;
        } else if($uAmount<=20) {
          $uResult = floor((1900+$caliber)*$rRatio);
        } else if($uAmount<=40) {
          $uResult = floor(($uAmount*120-500+$caliber)*$rRatio);
        } else if($uAmount<=70) {
          $uResult = floor(($uAmount*150-1700+$caliber)*$rRatio);
        } else if($uAmount<=200) {
          $uResult = floor(($uAmount*220-6600+$caliber)*$rRatio);
        } else if($uAmount<=6000) {
          $uResult = floor(($uAmount*270-16600+$caliber)*$rRatio);
        } else {
          $uResult = "エラー";
        }
      } else {
        if($uAmount == null) {
          echo null;
        } else if($uAmount<=20) {
          $uResult = floor((1900+$caliber));
        } else if($uAmount<=40) {
          $uResult = floor(($uAmount*120-500+$caliber));
        } else if($uAmount<=70) {
          $uResult = floor(($uAmount*150-1700+$caliber));
        } else if($uAmount<=200) {
          $uResult = floor(($uAmount*220-6600+$caliber));
        } else if($uAmount<=6000) {
          $uResult = floor(($uAmount*270-16600+$caliber));
        } else {
          $uResult = "エラー";
        }
      }

      //ここから下水の処理
      if($dAmount == null){
        $dResult = null;
      } else if($dAmount <= 20) {
        $dResult = 2200;
      } else if($dAmount <= 50) {
        $dResult = ($dAmount*120-200);
      } else if($dAmount <= 100){
        $dResult = ($dAmount*140-1200);
      } else if($dAmount <= 6000){
        $dResult = ($dAmount*150-2200);
      } else {
        $dResult = "エラー";
      }

      $uTaxPlus = floor($uResult*1.1);
      $dTaxPlus = $dResult*1.1;
    ?>

    <form action="calculator_water.php" name= "form" method="POST">
    <table width=750 border="1" cellpadding="2" cellspacing="0" bordercolor="#000000" bgcolor=#eeeeee>
      <tr><th colspan = "4">水道料金計算 滋賀県草津市(一般用)</th></tr>
      <tr>
        <th><label for="caliber" >口径<br /></label>
          <select name="caliber" id="caliber">
            <option name="caliber" value="120" <?php if($_POST['caliber']=="120"){echo 'selected = "selected"';}; ?>>13</option>
            <option name="caliber" value="400" <?php if($_POST['caliber']=="400"){echo 'selected = "selected"';}; ?>>20,25</option>
            <option name="caliber" value="800" <?php if($_POST['caliber']=="800"){echo 'selected = "selected"';}; ?>>30,40</option>
            <option name="caliber" value="4000" <?php if($_POST['caliber']=="4000"){echo 'selected = "selected"';}; ?>>50-100</option>
            <option name="caliber" value="8000" <?php if($_POST['caliber']=="8000"){echo 'selected = "selected"';}; ?>>150</option>
          </select>
        </th>
        <th>使用水量<br /><input type="text" name="amount" value="<?php echo $_POST['amount'];?>">㎡</th>
        <th><input type="checkbox" name="reduction" value="還元"<?php if($_POST['reduction']=="還元"){echo 'checked = "checked"';}; ?>>還元</th>
        <th><input type="submit" name="calculate" value="計算"></th>
      </tr>
    </table>
    </form>
    <br />
    <!--税抜き金額表示のテーブル-->
    <table width=750 border="1" cellpadding="2" cellspacing="0" bordercolor="#000000" bgcolor=#eeeeee>
      <tr>
        <th><label for="clean_bill">上水道料金</label></th>
        <th><label for="sewage_bill">下水道料金</label></th>
        <th><label for="total_bill">合計</label></th>
      </tr>
      <tr>
        <th><input type="text" size=20 id="clean_bill" name="amount" value="<?php echo $uResult;?>">円</th>
        <th><input type="text" size=20 id="sewage_bill" name="amount" value="<?= $dResult;?>">円</th>
        <th><input type="text" size=20 id="total_bill" name="amount" value="<?= $uResult+$dResult;?>">円</th>
      </tr>
    </table>

    <br />
    <!--税込み金額表示のテーブル-->
    <table width=750 border="2" cellpadding="2" cellspacing="0" bordercolor="#000000" bgcolor=#fe2e5e>
      <tr>
        <th><label for="clean_bill">上水道料金（税込み）</label></th>
        <th><label for="sewage_bill">下水道料金（税込み）</label></th>
        <th><label for="total_bill">合計（税込み）</label></th>
      </tr>
      <tr>
        <th><input type="text" size=20 id="clean_bill" name="amount" value="<?php echo $uTaxPlus;?>">円</th>
        <th><input type="text" size=20 id="sewage_bill" name="amount" value="<?= $dTaxPlus;?>">円</th>
        <th><input type="text" size=20 id="total_bill" name="amount" value="<?= $uTaxPlus+$dTaxPlus;?>">円</th>
      </tr>
    </table>
  </body>
</html>
