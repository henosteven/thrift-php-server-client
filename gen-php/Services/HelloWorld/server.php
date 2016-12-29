<?php
namespace Services\HelloWorld;
 
error_reporting(E_ALL);
 
define('THRIFT_ROOT', __DIR__ . '/../../../');
$THRIFT_ROOT = THRIFT_ROOT;
require_once  THRIFT_ROOT.'/Thrift/ClassLoader/ThriftClassLoader.php';
 
use Thrift\ClassLoader\ThriftClassLoader;
 
$loader = new ThriftClassLoader();
$loader->registerNamespace('Thrift',  THRIFT_ROOT);
$loader->registerDefinition('Service',  THRIFT_ROOT .'/gen-php');
$loader->register();
 
use Thrift\Exception\TException;
use Thrift\Factory\TBinaryProtocolFactory;
use Thrift\Factory\TBufferedTransportFactory;
use Thrift\Factory\TTransportFactory;
 
use Thrift\Server\TServerSocket;
use Thrift\Server\TSimpleServer;
 
//use Thrift\Server\TNonblockingServerSocket;
//use Thrift\Server\TNonblockingServer;
 
//use Thrift\Protocol\TBinaryProtocol;
//use Thrift\Transport\TPhpStream;
//use Thrift\Transport\TBufferedTransport;
 
 
try {
    require_once './HelloWorldHandler.php';
    $handler = new \Services\HelloWorld\HelloWorldHandler();
    $processor = new \Services\HelloWorld\HelloWorldProcessor($handler);
     
    //$transportFactory = new TBufferedTransportFactory();
    $transportFactory = new TTransportFactory();
    $protocolFactory = new TBinaryProtocolFactory(true, true);
     
    //作为cli方式运行，监听端口，官方实现
    $transport = new TServerSocket('localhost', 9090);
    $server = new TSimpleServer($processor, $transport, $transportFactory, $transportFactory, $protocolFactory, $protocolFactory);
    $server->serve();
     
    //作为cli方式运行，非阻塞方式监听，基于libevent实现，非官方实现
    //$transport = new TNonblockingServerSocket('localhost', 9090);
    //$server = new TNonblockingServer($processor, $transport, $transportFactory, $transportFactory, $protocolFactory, $protocolFactory);
    //$server->serve();
 
    //客户端和服务端在同一个输入输出流上
    //使用方式
    //1) cli 方式：php Client.php | php Server.php 
    //2) cgi 方式：利用Apache或nginx监听http请求，调用php-fpm处理，将请求转换为PHP标准输入输出流
    //$transport = new TBufferedTransport(new TPhpStream(TPhpStream::MODE_R | TPhpStream::MODE_W));
    //$protocol = new TBinaryProtocol($transport, true, true);
    //$transport->open();
    //$processor->process($protocol, $protocol);
    //$transport->close();
     
} catch (TException $tx) {
    print 'TException: '.$tx->getMessage()."\n";
}
