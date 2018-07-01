/*
* @Filename: check.js 
* @Author: ProboxDu
* @Date:   2018-06-14 18:11:09
* @Last Modified by:   ProboxDu
* @Last Modified time: 2018-07-01 11:41:36
*/


function checkReForm(){
    if(!check_Username() || !check_Password()|| !checkRepassword()|| !check_Phone()){
        alert("信息输入有误,请核对您的信息！");
        return false;
    }
    return true;
}
function checkLogForm(){
    if(!checkUsername() || !checkPassword()){
        alert("信息输入有误,请核对您的信息！");
        return false;
    }
    return true;
}

//验证用户名（为5~16个字符，且只能由字母、数字和"_"组成）
function checkUsername(){
    var bt=document.getElementById("username").value.trim();
    var name=document.getElementById("username").value.trim();
    var nameRegex=/^[0-9A-Za-z_]\w{4,15}$/;
    if(bt == ""){
        document.getElementById("nameInfo").innerHTML="不能为空哦！";
    }
    else if(!nameRegex.test(name)){
        document.getElementById("nameInfo").innerHTML="用户名为5~16个字符，只能由字母、数字和_组成";
    }else{
        document.getElementById("nameInfo").innerHTML="";
        return true;
    }
    return false;
}
function check_Username(){
    var bt=document.getElementById("_username").value.trim();
    var name=document.getElementById("_username").value.trim();
    var nameRegex=/^[0-9A-Za-z_]\w{4,15}$/;
    if(bt == ""){
        document.getElementById("_nameInfo").innerHTML="不能为空哦！";
    }
    else if(!nameRegex.test(name)){
        document.getElementById("_nameInfo").innerHTML="用户名为5~16个字符，只能由字母、数字和_组成";
    }else{
        document.getElementById("_nameInfo").innerHTML="";
        return true;
    }
    return false;
}
//验证phone不为空
function check_Phone(){
    var phone =document.getElementById("_phone").value.trim();
    var pattern = /^[0-9A]\w{4,10}$/;
    if(phone == ""){
        document.getElementById("phoneInfo").innerHTML="不能为空哦！";
    }else if (!pattern.test(phone)) {
        document.getElementById("phoneInfo").innerHTML = "请输入正确格式的phone哦！"
    }
    else{
        document.getElementById("phoneInfo").innerHTML="";
		return true;
    }
    return false;
}
//验证密码（长度在8个字符到16个字符）
function checkPassword(){
    var bt1=document.getElementById("password").value.trim();
    var password=document.getElementById("password").value.trim();
    $("#passwordInfo").innerHTML="";
    //密码长度在8个字符到16个字符，由字母、数字和"_"、"."组成
    var passwordRegex=/^[0-9A-Za-z_.]\w{7,15}$/;
    if(bt1 == ""){
        document.getElementById("passwordInfo").innerHTML="不能为空哦！";
    }
    else if(!passwordRegex.test(password)){
        document.getElementById("passwordInfo").innerHTML="密码长度必须在8个字符到16个字符之间哦！";
    }else{
        document.getElementById("passwordInfo").innerHTML="";
		return true;
    }
    return false;
}
function check_Password(){
    var bt1=document.getElementById("_password").value.trim();
    var password=document.getElementById("_password").value.trim();
    $("#_passwordInfo").innerHTML="";
    //密码长度在8个字符到16个字符，由字母、数字和".""_"组成
    //var passwordRegex=/^[0-9A-Za-z.\-\_\@\#\$]{8,16}$/;
    //密码长度在8个字符到16个字符，由字母、数字和"_"、"."组成
    var passwordRegex=/^[0-9A-Za-z_.]\w{7,15}$/;
    if(bt1 == ""){
        document.getElementById("_passwordInfo").innerHTML="不能为空哦！";
    }
    else if(!passwordRegex.test(password)){
        document.getElementById("_passwordInfo").innerHTML="密码长度必须在8个字符到16个字符之间哦！";
    }else{
        document.getElementById("_passwordInfo").innerHTML="";
		return true;
    }
    return false;
}
//验证校验密码（和上面密码必须一致）
function checkRepassword(){
    var bt1=document.getElementById("repassword").value.trim();
    var repassword=document.getElementById("repassword").value.trim();
    var password=document.getElementById("_password").value.trim();
    //校验密码和上面密码必须一致
    if(bt1 == ""){
        document.getElementById("repasswordInfo").innerHTML="不能为空哦！";
    }
    else if(repassword!=password){
        document.getElementById("repasswordInfo").innerHTML="两次输入的密码不一致哦！";
    }else if(repassword == password){
        document.getElementById("repasswordInfo").innerHTML="";
		return true;
    }
    return false;
}
$('#avatarInput').on('change', function(e) {
		var filemaxsize = 1024 * 5;//5M
		var target = $(e.target);
		var Size = target[0].files[0].size / 1024;
		if(Size > filemaxsize) {
			alert('图片过大，请重新选择!');
			$(".avatar-wrapper").childre().remove;
			return false;
		}
		if(!this.files[0].type.match(/image.*/)) {
			alert('请选择正确的图片!')
		} else {
			var filename = document.querySelector("#avatar-name");
			var texts = document.querySelector("#avatarInput").value;
			var teststr = texts; //你这里的路径写错了
			testend = teststr.match(/[^\\]+\.[^\(]+/i); //直接完整文件名的
			filename.innerHTML = testend;
		}
	
	});

	$(".avatar-save").on("click", function() {
		var img_lg = document.getElementById('imageHead');
		// 截图小的显示框内的内容
		html2canvas(img_lg, {
			allowTaint: true,
			taintTest: false,
			onrendered: function(canvas) {
				canvas.id = "mycanvas";
				//生成base64图片数据
				var dataUrl = canvas.toDataURL("image/jpeg");
				var newImg = document.createElement("img");
				newImg.src = dataUrl;
				imagesAjax(dataUrl)
			}
		});
	})
	
	function imagesAjax(src) {
		var data = {};
		data.img = src;
		data.jid = $('#jid').val();
		$.ajax({
			url: "upload-logo.php",
			data: data,
			type: "POST",
			dataType: 'json',
			success: function(re) {
				if(re.status == '1') {
					$('.user_pic img').attr('src',src );
				}
			}
		});
	}