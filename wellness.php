<?php 
    ini_set('display_errors', "On");

    require_once './Requests/src/Autoload.php';
    WpOrg\Requests\Autoload::register();

    if(isset($_GET['studentid'])&&isset($_GET['password'])){ 
        $studentid = $_GET['studentid'];
        $password = $_GET['password']; 
        $url = "https://wellness.sfc.keio.ac.jp/v3/index.php";
        $cal_url = "https://wellness.sfc.keio.ac.jp/v3/index.php?page=ics&mode=student";

        $login_data = array(
            'login'=> $studentid,
            'password'=> $password,
            'submit'=>"login",
            "page"=>"top",
            "mode"=>"login",);
        $session = new \WpOrg\Requests\Session();
        $session->post($url,array(),$login_data);
        $response = $session->get($cal_url);
        header("Content-type: text/calendar; charset=utf-8");
        print($response->body);

    } else{
        echo 
            '<div>
                <table class="itemize">
                <tbody><tr>
                    <th>ログイン名:</th>
                    <td><input id="cnsid" type="text" name="cnsid" value="" placeholder="ログイン名"></td>
                </tr>
                <tr>
                    <th>パスワード:</th>
                    <td><input id="cnspass" type="password" name="cnspass" value="" placeholder="パスワード"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input id="submit" type="submit" name="submit" value="発行"></td>
                </tr>
                <tr>
                    <th>Webcal URL:</th>
                    <td>
                        <input id="webcal" type="text" name="webcal" value="" placeholder="発行ボタンをクリック" readonly>
                    </td>
                    <td id="buttons" style="display:none;">
                        <input id="copy" type="submit" name="copy" value="URLをコピー">
                        <input id="add" type="submit" name="add" value="システムカレンダーに追加">
                        <input id="addg" type="submit" name="addg" value="Googleカレンダーに追加">
                        <input id="dl" type="submit" name="dl" value="ics形式でダウンロード">
                    </td>
                </tr>
                </tbody></table>
            </div>
            <br>
            <a href="https://github.com/nukemiri/sfc_webcal" target="_blank">Github</a>
            <script type="text/javascript">
                document.getElementById("submit").onclick = function() {
                    document.getElementById("buttons").style.display ="block";
                    let url = location.href;
                    if (location.search=="") {
                        url += "?studentid="+document.getElementById("cnsid").value+"&password="+document.getElementById("cnspass").value;
                    }else{
                        url = url.replace(location.search , "?studentid="+document.getElementById("cnsid").value+"&password="+document.getElementById("cnspass").value);
                    }
                    url = url.replace(location.hash , "");
                    url = url.replace(location.protocol , "webcal:");
                    document.getElementById("webcal").value = url;

                };
                document.getElementById("copy").onclick = function() {
                    navigator.clipboard.writeText(String(document.getElementById("webcal").value))
                        .then(
                        success => alert("テキストのコピーに成功"),
                        error => alert("テキストのコピーに失敗")
                        );
                };
                document.getElementById("add").onclick = function() {
                    window.open(document.getElementById("webcal").value);
                };
                document.getElementById("addg").onclick = function() {
                    window.open("https://www.google.com/calendar/render?cid="+String(document.getElementById("webcal").value).replace("&","%26"));
                };
                document.getElementById("dl").onclick = function() {
                    window.open(document.getElementById("webcal").value.replace("webcal","http"));
                };
            </script>'
            ;
    }

    

    
 ?>