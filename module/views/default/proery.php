<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,maximum-scale=1.0,user-scalable=no,initial-scale=1.0">
    <title><?php echo $list['title']; ?></title>
    <style type="text/css">
        html,body,ul,li,ol,dl,dd,dt,p,h1,h2,h3,h4,h5,h6,form,fieldset,legend,img{
            margin:0;
            padding:0;
            outline: 0;
            border: 0;
            list-style: none;
        }
        h1{
            font-size: 26px;
            text-align: center;
            margin-top: 0.5rem;
            padding:0 0.3rem;
        }
        .source{
            font-size: 14px;
            text-align: center;
            padding: 0.3rem 0;
        }
        .content{
            padding:0 0.3rem;
            font-size: 18px;
            text-align: justify;
        }
        .content p>img{
            width: 80%;
            margin-left:30px ;
        }
    </style>
    <script>
        (function(doc, win) {
            var docEl = doc.documentElement,
                resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                recalc = function() {
                    var clientWidth = docEl.clientWidth;
                    if(!clientWidth) return;
                    if(clientWidth >= 640) {
                        docEl.style.fontSize = '100px';
                    } else {
                        docEl.style.fontSize = 100 * (clientWidth / 640) + 'px';
                    }
                };
            if(!doc.addEventListener) return;
            win.addEventListener(resizeEvt, recalc, false);
            doc.addEventListener('DOMContentLoaded', recalc, false);
        })(document, window);
        window.onload=function(){
            console.log(document.documentElement.style.fontSize)
        }
    </script>
</head>
<body>
<div class="title">
    <h1><?php echo $list['title']; ?></h1>
    <div class="source"><span><?php if($list['cateId'] ==1){echo "物业通知";}else if($list['cateId']==2){echo "";}else{echo "系统通知";} ?></span><?php if($list['cateId']!=2):?><span><?php echo $list['createTime']; ?></span>
	<?php endif; ?>
	</div>
</div>
<div class="content">
    <!--内容部分-->
    <?php echo $list['content'];?>
</div>
</body>
</html>