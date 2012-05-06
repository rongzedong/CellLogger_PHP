<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php 
if(isset($title)) {
    echo htmlspecialchars($title); 
} else {
    echo 'CL';
}
?></title>
<!-- <?php echo htmlspecialchars(php_uname('n')); ?> -->

<script type="text/javascript" src="res/jquery-1.7.1.min.js"></script>
<script type="text/javascript">

</script>

<style type="text/css">
/* {{{ */
* {
    font-size: 14px;
    color: #333;
    font-family: arial,sans-serif;
}

a  {
    color: #77f;
}
a:hover  {
    color: #00f;
}

.rr {
    text-align: right; 
}

.ll {
    text-align: left; 
}

.ss {
    font-size: 10px;
}

.cc {
    text-align: center;
}

th {
    background-color: #ccc;
}

.hover { 
    background-color: #eee; 
}
.hi {
    background-color: #ffc;
}

.hover * { 
    color: #000;
}



#header {
    background-color: #ccccee;
    line-height: 44px;
    font-size: 24px;
    font-weight: bold;
    text-indent: 1em;
}

#header p {
    line-height: 24px;
}

#footer {
    background-color: #cccccc;
    line-height: 44px;
    font-size: 18px;
    font-weight: bold;
    text-indent: 1em;
}

.pager {
    text-align: right;
}

.buttons {
    margin: 0 12px;
}

.buttons button {
    float: left;
}

.cell span {
    background-color: #ccc;
    margin: 0 4px;
}

/* }}} */
</style>

</head>
<body class="<?php echo get_browser_class_name(); ?>">


        <div id="page">
            <div id="header">
                Cell Logger Console

                <p>
                    <a href="record.php">Records</a> | 
                    <a href="station.php">Stations</a>
                </p>
            </div>
            <hr />
            <div id="main">
               

