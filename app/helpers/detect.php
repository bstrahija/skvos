<?php

if (class_exists('Mobile_Detect'))
{
	if ( ! function_exists('is_mobile'))
	{
		function is_mobile()
		{
			$detect = new Mobile_Detect;

			return $detect->isMobile();
		}
	}

	if ( ! function_exists('is_iphone'))
	{
		function is_iphone()
		{
			$detect = new Mobile_Detect;

			return $detect->isIphone();
		}
	}
}
