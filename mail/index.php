<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$_SESSION["session_flag"] = md5(time().rand());
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!--[if lt ie 7]> <html class="ie ie6" lang="zh-CN"> <![endif]-->
<!--[if ie 7]>    <html class="ie ie7" lang="zh-CN"> <![endif]-->
<!--[if ie 8]>    <html class="ie ie8" lang="zh-CN"> <![endif]-->
<!--[if gt ie 8]><!-->  <html> <!--<![endif]-->
 <head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>tonny zhang，放飞心灵</title>
		<meta name="Author" content="tonny zhang"/>
		<meta name="Keywords" content="tonny zhangkai,wodexintiao@gmail.com"/>
		<meta name="Description" content="tonny zhangkai,wodexintiao@gmail.com"/>
		<!-- <link rel="stylesheet" type="text/css" media="screen" href="css/base.css"> -->
		<style>
		/* Clearfix */
		.clearfix:after {/*用于内部有浮动元素的元素，可以起到关闭浮动的作用 */
			content: ".";
			display: block;
			height: 0;
			clear: both;
			visibility: hidden;
		}
		.clearfix {
			display: inline;
		}
		table{
			background: #5B8DD9;
			font-size: 12px;
			width: 500px;
			margin: 10px auto;
			color:#333;
		}
		table td{
			background: white;
			padding: 3px;
		}
		table .textBox{
			width: 300px;
			padding:2px;
		}
		.hide{
			display: none;
		}
		.err{
			background-color: red;
		}
		</style>
		<script src="http://misc.weather.com.cn/min/j/core.js"></script>
	</head>
	<body>
		<form action="./send.php" method="POST">
			<input type="hidden" name="hook" value="<?php echo $_SESSION["session_flag"];?>"/>
			<table>
				<tr>
					<td>发送主题</td>
					<td>
						<input type="text" class="textBox" name="send_subject" placeholder="请输入发送主题"/>
					</td>
				</tr>
				<tr>
					<td>发送对象</td>
					<td>
						<div><input type="checkbox" checked id="checkall"/><label>全选</label></div>
						<?php
						$emailList = require_once('./emailList.php');
						foreach ($emailList as $key=>$info) {
							$email = $info['email'];
						?>
						<div><input type="checkbox" checked value="<?php echo $email;?>" name="send_address[]"/><label><?php echo $email;?></label></div>
						<?php }?>
					</td>
				</tr>
				<tr>
					<td width="30%">发送内容</td>
					<td>
						<input type="radio" value="1" name="send_type" checked/><label>文本</label>
						<input type="radio" value="2" name="send_type"/><label>从文件</label>
						<div id="type_text">
							<textarea class="textBox" id="send_text" name="send_text" placeholder="请输入要发送的文本内容"></textarea>
						</div>
						<div id="type_file" class="hide">
							<input type="text" class="textBox" id="send_file" name="send_file" placeholder="请输入URL"/>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan=2 align=center>
						<input type="button" value="发送" id="btn_send"/>
					</td>
				</tr>
			</table>
		</form>
		<script>
		W(function(){
			W.use('http://rawgithub.com/mathiasbynens/jquery-placeholder/master/jquery.placeholder.js',function(){
				$('[placeholder]').placeholder();
			});
			var allAddress = $('input:checkbox[name="send_address[]"]');
			$('#checkall').click(function(){
				allAddress.prop('checked',$(this).prop('checked'))
			});
			// $('label').click(function(){
			// 	$(this).prev('input:checkbox').click();
			// });
			var send_type = $('input:radio[name=send_type]').click(function(){
				var index = send_type.index($(this));
				if(index == 0){
					$('#type_text').show();
					$('#type_file').hide();
				}else{
					$('#type_text').hide();
					$('#type_file').show();
				}
			});
			var subject = $('[name=send_subject]');
			$('#btn_send').click(function(){
				(subject.closest('td'))[subject.val()?'removeClass':'addClass']('err');
				for(var i =0,j=allAddress.length;i<j;i++){
					if(allAddress.eq(i).prop('checked')){
						break;
					}
				}
				(allAddress.closest('td'))[i != j?'removeClass':'addClass']('err');
				var index = send_type.index(send_type.filter(':checked'));
				if(index == 0){
					(send_type.closest('td'))[$('#send_text').val()?'removeClass':'addClass']('err');
				}else{
					(send_type.closest('td'))[$('#send_file').val()?'removeClass':'addClass']('err');
				}

				if($('form .err').length == 0){
					$('form').submit();
				}
			});
		});
		</script>
	</body>
</html>
