卷 系统 的文件夹 PATH 列表
卷序列号为 06C1-D849
C:.
│  index.php                //服务器端主体逻辑，从搜索页面进入，匹配搜索关键字后，生成预览和中间jason文件，然后通过按键触发下载
│  readme.txt
│  
├─inc
│  │  code.php
│  │  conn.php              //php的常量配置，例如页面标题，关键字定义
│  │  pubs.php
│  │  safe.php
│  │  sqls.php              //sql的配置，注意，明文包含了密码等信息
│  │  
│  ├─css
│  │      line_bg.jpg
│  │      style.css
│  │      
│  └─js
│          js.js            //定义页面交互触发的函数
│          
├─json                      //查询时触发生成临时文件，供用户主动下载
└─process                   //服务器后端预处理数据的python目录
        clean.py            //清洗数据，先按照公司分类，建立中间文件，然后对中间文件逐条清洗，按需求替换内容
        config.py           //python目录的配置文件
        create.sql          //创建数据库的脚本，执行一次
        detect.py           //检测数据源目录是否有新数据进来，有的话通过比较record.txt记录，找出新增量，触发处理流程
        load.py             //数据装载到MySQL
        main.py             //python目录入口
        record.txt          //记录文件，记录数据源已处理过的数据
        
