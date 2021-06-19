<?php

/**
 * Defines a contract for an interceptor that executes around calls to remote services
 * in both client and servers
 * @author vsayajin
 */
interface IHessianInterceptor
{

    function beforeRequest(HessianCallingContext $context);

    function afterRequest(HessianCallingContext $context);
}