<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="http://cdn.static.runoob.com/libs/jquery/1.10.2/jquery.min.js"></script>
</head>
<body>
	fsdafds
	<script type="text/javascript">
		// $.get('/api/register',function(data,status){
		// 	console.log(status)
		// 	alert(data.message)
		// },'json')
		// $.ajax({
		//    type: "GET",
		//    // dataType: 'json',
		//    url: "/api/register",
		//    data: "username=test1&email=cnsdwu1@163.com&password=123",
		//    success: function(msg){
		//      // alert( "Data Saved: " + msg );
		//      console.log(msg)
		//    },
		//    error: function(msg){
		//    	// alert( "Data Saved: " + msg.message );
		//    	console.log(msg)
		//    }
		// });
		// $.ajax({
		//    type: "GET",
		//    // dataType: 'json',
		//    url: "/api/login",
		//    data: "account=cnsdwu@163.com&password=123",
		//    success: function(msg){
		//      // alert( "Data Saved: " + msg );
		//      console.log(msg)
		//    },
		//    error: function(msg){
		//    	// alert( "Data Saved: " + msg.message );
		//    	console.log(msg)
		//    }
		// });
		// $.ajax({
		//    type: "GET",
		//    // dataType: 'json',
		//    url: "/api/article/add",
		//    data: "type=1&title=test&content=123&account=test&password=123&token=5a868eed8fc25aed6450a40ad5cdccbb",
		//    success: function(msg){
		//      // alert( "Data Saved: " + msg );
		//      console.log(msg)
		//    },
		//    error: function(msg){
		//    	// alert( "Data Saved: " + msg.message );
		//    	console.log(msg)
		//    }
		// });
		// $.ajax({
		//    type: "GET",
		//    // dataType: 'json',
		//    url: "/api/article",
		//    data: "id=9&type=1&title=test&content=123&account=test&password=123&token=5a868eed8fc25aed6450a40ad5cdccbb",
		//    success: function(msg){
		//      // alert( "Data Saved: " + msg );
		//      console.log(msg)
		//    },
		//    error: function(msg){
		//    	// alert( "Data Saved: " + msg.message );
		//    	console.log(msg)
		//    }
		// });
		// $.ajax({
		//    type: "GET",
		//    // dataType: 'json',
		//    url: "/api/article/list",
		//    data: "take=5&skip=&id=9&type=1&title=test&content=123&account=test&password=123&token=5a868eed8fc25aed6450a40ad5cdccbb",
		//    success: function(msg){
		//      // alert( "Data Saved: " + msg );
		//      console.log(JSON.parse(msg.ps))
		//    },
		//    error: function(msg){
		//    	// alert( "Data Saved: " + msg.message );
		//    	console.log(msg)
		//    }
		// });
		$.ajax({
		   type: "POST",
		   // dataType: 'json',
		   url: "http://api.wwzc.cc/api/article/add",
		   data: "username=test1&email=cnsdwu1@163.com&password=123",
		   success: function(msg){
		     // alert( "Data Saved: " + msg );
		     console.log(msg)
		   },
		   error: function(msg){
		   	// alert( "Data Saved: " + msg.message );
		   	console.log(msg)
		   }
		});
	</script>
</body>
</html>