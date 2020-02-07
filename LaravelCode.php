<?php
/*
1、创建项目
	composer create-project laravel/Laravel=5.6.* --prefer-dist ./
命令说明
	create-project:通过composer去创建项目；
	laravel/Laravel：项目名称
	=5.6.*代表版本号
--	prefer-dist：优先下载压缩方式而不是直接从github上下载源码（克隆）
2、启动方式
	php artisan serve
指定运行端口
	php artisan serve --host=0.0.0.0 --port=8080
3、查看已有的路由命令
	php artisan route:list
4、创建控制器(TestController未控制器名称)
	php artisan make:controller TestController
如果需要分目录生成控制器(在admin文件夹里面生成IndexConroller控制器)
	php artisan make:controller Admin/IndexController
5、从csrf验证中排除路由
	5.1可在app\Http\Middleware\VerifyCsrfToken添加路由规则
	5.2或写'*'排除所有的验证
6、创建model,Member是文件模型的名词
	php artisan make:model Member
7、安装语音包
	安装命令:composer require caouecs/laravel-lang:~3.0
	将zh-CN文件包移到lang目录下
	修改默认语音：进去app.php修改locale字段，改成zh-cn
8、安装验证码包
8.1，安装命令：
	composer require mews/captcha
8.2.在config\app.php添加扩展
	Mews\Captcha\CaptchaServiceProvider::class
8.2.配置别名，在config\app.php的aliases键
	'Captcha' => Mews\Captcha\Facades\Captcha::class,
8.3.设置一个配置
	php artisan vendor:publish
8.4.选8，生成配置文件
9、数据迁移
	9.1：迁移文件存放在database\migrations
	9.2：创建迁移文件
		php artisan make:migration 迁移文件(如：php artisan make:migration create_paper_table)
	9.3：如果第一次执行迁移文件,先创建迁移文件的记录数据表
		php artisan migrate:install
	9.4:执行文件，穿件数据表
		php artisan migrate
	9.5：回滚迁移操作：
		php artisan migrate:rollback
10、数据填充
	10.1:放在database\seeds
	10.2:创建填充器名：
		php artisan make:seeder 填充名称（如：以上面paper为例，php artisan make:seeder PaperTableSeeder）
	10.3:执行填充器文件：
		php artisan db:seed --class=需要执行的种子文件名（如：php artisan db:seed --class=PaperTable）
11、项目初始化
	1、创建目录
		composer create-project laravel/Laravel=5.6.* --prefer-dist ./
	2、连接数据库修改
		修改.env文件,生成app_key(php artisan key:generate)
	3、修改语言包，参考第7点
	4、修改时区：
		在cofing\app.php里的timezone
	5、删除默认文件
		5.1:app/Http/Controllers/Auth/的目录
		5.2:/database/migrations，默认的迁移文件
		5.3:/database/seeds默认文件
		5.4:resources/views/welcome.blade.php
	6、关闭mysql的严格模式
		编辑config\database.php,将strict变成false
	7、安装debugbar工具条
		7.1:安装命令：composer require barryvdh/laravel-debugbar --dev
		7.2:修改app配置文件，providers和aliases
		'providers' => [
		   Barryvdh\Debugbar\ServiceProvider::class,
		 ]
		'aliases' => [
		   'Debugbar' => Barryvdh\Debugbar\Facade::class,
		 ]
		 7.3:设置全局应用
		 php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"
12、创建中间件
	12.1：创建中间件命令
		php artisan make:middleware IsLogin
	12.2：中间件文件路径
		app\Http\Middleware
	12.3：注册中间件文件
		app\Http\Kernel.php
13、安装图片处理组件
	13.1：安装组件
		composer require intervention/image
	13.2：配置
		在config/app.php添加
		providers=>[
			Intervention\Image\ImageServiceProvider::class,
		],
		aliases[
			'Image' => Intervention\Image\Facades\Image::class,
		]
	13.3：使用，
		查看laravelBlog项目里面的ArticleController的upload方法
14、markdown编辑器
	14.1：安装
		composer require graham-campbell/markdown
	14.2：配置
		providers=>[
			GrahamCampbell\Markdown\MarkdownServiceProvider::class,
		],
		aliases[
			'Markdown' => GrahamCampbell\Markdown\Facades\Markdown::class,
		]
	14.3：使用方法
		查看laravelBlog项目里面的ArticleController的pre_mk方法
15、阿里云oss(1.0)
	15.1：安装
		包源网址：http://packagist.p2hp.com/packages/johnlui/aliyun-oss
		composer require johnlui/aliyun-oss:~1.0
	15.2：配置
		15.2.1：配置文件在config/alioss里
		15.2.2：在.evn更新阿里云oss配置
		15.2.3：oss类路径在App/Services/OSS;
	15.3：使用方法
		查看laravelBlog项目里面的ArticleController的upload方法
16、七牛oss
	16.1：安装
		composer require "overtrue/laravel-filesystem-qiniu"
	16.2：配置
		providers=>[
			Overtrue\LaravelFilesystem\Qiniu\QiniuStorageServiceProvider::class,
		],
		在config/filesystems.php
		disks=>[
			'qiniu' => [
            'driver'     => 'qiniu',
            'access_key' => env('QINIU_ACCESS_KEY', 'xxxxxxxxxxxxxxxx'),
            'secret_key' => env('QINIU_SECRET_KEY', 'xxxxxxxxxxxxxxxx'),
            'bucket'     => env('QINIU_BUCKET', 'test'),
            'domain'     => env('QINIU_DOMAIN', 'xxx.clouddn.com'), // or host: https://xxxx.clouddn.com
        ],
		16.2.2：在.evn更新七牛配置
	16.3：使用方法
		查看laravelBlog项目里面的ArticleController的pre_mk方法
17、安装redis扩展
	17.1：安装
		composer require "predis/predis:~1.0"
	17.2：修改redis配置
		文件配置在config/database.php
	17.3：使用方法
		查看laravelBlog项目里面的ArticleController的index方法

