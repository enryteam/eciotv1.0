<?php

/**
 * Used for custom writers that handle a particular class type
 * @author vsayajin
 */
interface IHessianCustomWriter
{

    function write($writer, $data);
}