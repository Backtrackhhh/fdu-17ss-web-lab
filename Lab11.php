<html>
<head>
    <title>LRC 歌词编辑器</title>
    <style>
        nav ul {
            position: fixed;
            z-index: 99;
            right: 5%;
            border: 1px solid darkgray;
            border-radius: 5px;
            list-style:none;
            padding: 0;
        }
        .tab {
            padding: 1em;
            display: block;
        }
        .tab:hover {
            cursor: pointer;
            background-color: lightgray !important;
        }
        td {
            padding:0.2em;
        }
        textarea[name="edit_lyric"] {
            width: 100%;
            height: 50em;
        }
        input[type="button"] {
            width: 100%;
            height: 100%;
        }
        input[type="submit"] {
            width: 100%;
            height: 100%;
        }
        #td_submit {
            text-align: center;
        }
        select {
            display: block;
        }
        #lyric {
            width: 35%;
            height: 60%;
            border: 0;
            resize: none;
            font-size: large;
            line-height: 2em;
            text-align: center;
        }
    </style>
</head>
<body>
<nav><ul>
    <li id="d_edit" class="tab">Edit Lyric</li>
    <li id="d_show" class="tab">Show Lyric</li>
</ul></nav>

<!--歌词编辑部分-->
<section id="s_edit" class="content">
    <form id="f_upload" enctype="multipart/form-data">
        <p>请上传音乐文件</p>

        <!--TODO: 在这里补充 html 元素，使 file_upload 上传后若为音乐文件，则可以直接播放-->

        <input type="file" name="file_upload" id="file_upload">
        <audio src="" controls = "controls"></audio>
        <table>
            <tr><td>Title: <input type="text"></td><td>Artist: <input type="text"></td></tr>
            <tr><td colspan="2"><textarea name="edit_lyric" id="edit_lyric"></textarea></td></tr>
            <tr><td><input type="button" value="插入时间标签"></td><td><input type="button" value="替换时间标签"></td></tr>
            <tr><td colspan="2" id="td_submit"><input type="submit" value="Submit"></td></tr>
        </table>
    </form>
</section>

<!--歌词展示部分-->
<section id="s_show" class="content">
    <select>
        <?php
         $files = scandir("songs/mp3");
           for ($i =0;$i<count($files);$i++){
            if ($files[$i]!='.'&&$files[$i]!="..") {
                $t = basename($files[$i],'.mp3');
                echo "<option value='$files[$i]' data-sort=$i>$t</option>";
        }
        }
        ?>
        <!--TODO: 在这里补充 html 元素，使点开 #d_show 之后这里实时加载服务器中已有的歌名-->

    </select>

    <audio src="" controls="controls" id="player2"></audio>
    <button onclick="reduce()">上一首</button>
    <button onclick="add()">下一首</button>
    <textarea id="lyric" readonly="true">
    </textarea>

    <!--TODO: 在这里补充 html 元素，使选择了歌曲之后这里展示歌曲进度条，并且支持上下首切换-->
    <audio id="play1">
        <source src="songs/Jay-Z,Alicia Keys - Empire State Of Mind.mp3"></source>
    </audio>
    <audio id="play2">
        <source src="songs/Jay-Z,Alicia Keys - Empire State Of Mind.mp3"></source>
    </audio>
    <audio id="play3">
        <source src="songs/Jay-Z,Alicia Keys - Empire State Of Mind.mp3"></source>
    </audio>


</section>
</body>
<script>
    play1=document.getElementById("play1");
    play2=document.getElementById("play2");
    play3=document.getElementById("play3");
    play=[play1,play2,play3];

    function checkType(ths) {
        if (/\.(MP3|mp3|wav|WAV|cda|CDA|wma|WMA)$/.test(ths.value)) {
            return true;}
        else
            return false;
    }

    //点击播放、暂停
    function start(){
        minute=0;
        if(flag){
            imagePause();
            play[index].pause();
        }else{
            rotate();
            play[index].play();
            reducejindutiao();
            addtime();
            jindutiao();
            for (var i=0;i<play.length;i++) {
                audioall[i].style.color="white";
            }
            audioall[index].style.color="red";
        }
    }

    //图片旋转，每30毫米旋转5度
    function rotate(){
        var deg=0;
        flag=1;
        timer=setInterval(function(){
            image.style.transform="rotate("+deg+"deg)";
            deg+=5;
            if(deg>360){
                deg=0;
            }
        },30);
    }

    function imagePause(){
        clearInterval(timer);
        flag=0;
    }
    function jindutiao(){
        //获取当前歌曲的歌长
        var lenth=play[index].duration;
        timer1=setInterval(function(){
            cur=play[index].currentTime;//获取当前的播放时间
            fillbar.style.width=""+parseFloat(cur/lenth)*300+"px";
        },50)
    }

    //播放时间
    function addtime(){
        timer2=setInterval(function(){
            cur=parseInt(play[index].currentTime);//秒数
            var temp=cur;
            minute=parseInt(temp/60);
            if(cur%60<10){
                time.innerHTML=""+minute+":0"+cur%60+"";
            }else{
                time.innerHTML=""+minute+":"+cur%60+"";
            }
        },1000);
    }

    //上一曲
    function reduce(){
        qingkong();
        reducejindutiao();
        pauseall();
        index--;
        if(index==-1){
            index=play.length-1;
        }
        start();
    }
    //下一曲
    function add(){
        qingkong();
        reducejindutiao();
        pauseall();
        index++;
        if(index>play.length-1){
            index=0;
        }
        start();
    }

    //点击文字切歌
    function change(e){
        var musicName=e.target;
        //先清空所有的
        for (var i=0;i<audioall.length;i++) {
            audioall[i].style.color="white";
            if(audioall[i]==musicName){
                musicName.style.color="red";
                qingkong();
                reducejindutiao();
                pauseall();
                index=i;
                start();
            }
        }
    }

    function reducejindutiao(){
        clearInterval(timer1);
        fillbar.style.width="0";
    }

    function qingkong(){//清空所有的计时器
        imagePause();
        clearInterval(timer2);
    }

    //音乐停止
    function pauseall(){
        for (var i=0;i<play.length;i++) {
            if(play[i]){
                play[i].pause();
            }
        }
    }

    //调整播放进度
    function adjust(e){
        var bar=e.target;
        var x=e.offsetX;
        var lenth=play[index].duration;
        fillbar.style.width=x+"px";
        play[index].currentTime=""+parseInt(x*lenth/300)+"";
        play[index].play();
    }

    //调整音量大小
    function changeVolume(e){
        var x=e.offsetX+20;
        play[index].volume=parseFloat(x/200)*1;
        //改变按钮的位置
        volume3.style.left=""+x+"px";
    }
    // var type = document.getElementsByName("file_upload")[0];
    // if(checkType(type)){


    //随机播放歌曲
    function suiji(e){
        var img=e.target;
        img2.style.border="";
        img.style.border="1px solid red";
    }
    //顺序播放
    function shunxu(){

        clearInterval(suijiplay);
        shunxuplay=setInterval(function(){
            if(play[index].ended){
                add();
            }
        },1000);
    }

    // }
    // 界面部分
    document.getElementById("d_edit").onclick = function () {click_tab("edit");};
    document.getElementById("d_show").onclick = function () {click_tab("show");};
    document.getElementById("d_show").click();
    function click_tab(tag) {
        for (let i = 0; i < document.getElementsByClassName("tab").length; i++) document.getElementsByClassName("tab")[i].style.backgroundColor = "transparent";
        for (let i = 0; i < document.getElementsByClassName("content").length; i++) document.getElementsByClassName("content")[i].style.display = "none";
        document.getElementById("s_" + tag).style.display = "block";
        document.getElementById("d_" + tag).style.backgroundColor = "darkgray";
    }
    // Edit 部分
    var edit_lyric_pos = 0;
    document.getElementById("edit_lyric").onmouseleave = function () {
        edit_lyric_pos = document.getElementById("edit_lyric").selectionStart;
    };
    // 获取所在行的初始位置。
    function get_target_pos(n_pos) {
        if (n_pos === undefined) n_pos = edit_lyric_pos;
        let value = document.getElementById("edit_lyric").value;
        let pos = 0;
        for (let i = n_pos; i >= 0; i--) {
            if (value.charAt(i) === '\n') {
                pos = i + 1;
                break;
            }
        }
        return pos;
    }
    // 选中所在行。
    function get_target_line(n_pos) {
        let value = document.getElementById("edit_lyric").value;
        let f_pos = get_target_pos(n_pos);
        let l_pos = 0;
        for (let i = f_pos;; i++) {
            if (value.charAt(i) === '\n') {
                l_pos = i + 1;
                break;
            }
        }
        return [f_pos, l_pos];
    }
    /* HINT:
     * 已经帮你写好了寻找每行开头的位置，可以使用 get_target_pos()
     * 来获取第一个位置，从而插入相应的歌词时间。
     * 在 textarea 中，可以通过这个 DOM 节点的 selectionStart 和
     * selectionEnd 获取相对应的位置。
     *
     * TODO: 请实现你的歌词时间标签插入效果。
     */
    /* TODO: 请实现你的上传功能，需包含一个音乐文件和你写好的歌词文本。
     */
    /* HINT:
     * 实现歌词和时间的匹配的时候推荐使用 Map class，ES6 自带。
     * 在 Map 中，key 的值必须是字符串，但是可以通过字符串直接比较。
     * 每一行行高可粗略估计为 40，根据电脑差异或许会有不同。
     * 当前歌词请以粗体显示。
     * 从第八行开始，当歌曲转至下一行的时候，需要调整滚动条，使得当前歌
     * 词保持在正中。
     *
     * TODO: 请实现你的歌词滚动效果。
     */
    shunxu();
</script>
</html>
