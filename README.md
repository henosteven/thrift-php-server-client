# thrift-php-server-client
thrift php -  server - php - client仅供后期查看使用，没有任何生产力价值。在处理的时候，还是遇到了比较多坑
例如: thrift --gen php:server HelloWorld.thrift 时候并没有生成相应Services目录，而且在声场的HelloWorld.php 文件中有语法错误,
看来与namespace php Services.HelloWorld 的使用方式有关系。而且可能是因为版本问题，有些代码报错，最终通过处理代码解决，勉强能跑起来,
后期将会继续学习，加强IDL的使用。
核心设计： bussiness - < processsor - protocal - transport >
