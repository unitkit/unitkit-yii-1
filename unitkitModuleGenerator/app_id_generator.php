<?php
/**
 * Generator of application ID
 */
echo hash('sha256', uniqid(uniqid(null, true) . ':unitkit', true));