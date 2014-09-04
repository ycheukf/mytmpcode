======系统环境要求======
centos 5.8+ (或其他linux发行版)
apache 2.2 (端口必须使用80)
php 5.3.+ 
imagemagik 最新版  下载地址(http://www.imagemagick.org/download/ImageMagick.tar.gz) 与 安装方法(http://www.imagemagick.org/script/install-source.php)

======代码部署======
1: 服务器部署.
	将程序包部署解压到相应apache www 目录下后, 权限调整
	cd 程序解压目录
	chmod -cR 755 *
	chmod -cR 777 ./tmp
	chmod -cR 777 ./data
2: 微信部署.
	将微信服务号的开发者模式访问地址改为 http://程序目录/wx.service.php
	将微信服务号验证 http://程序目录/wx.service.php?action=valid
3: 测试.
	浏览器中访问  http://程序目录/test.php, 输出 "OK"无报错 . 
	访问 http://程序目录/show.php?pickey=demo 以查看效果输出是否正确
	关注该微信号上传图片以验证效果
	

======注意======
程序需要调用命令行, 请确保以下路径中命令可调用
/usr/bin/php
/usr/local/bin/convert
/usr/local/bin/composite


