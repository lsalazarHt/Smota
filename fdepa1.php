<!DOCTYPE html>

<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<meta charset=utf-8 />
<title>Key</title>
</head>
<style type="text/css">
.a, .s, .d{
    padding: 50px;
    display: block;
    float: left;
    margin-right: 30px;
    background: gray;
    color: white;
}
</style>
<body>
    <div class="a">A</div>
    <div class="s">S</div>
    <div class="d">D</div>
    <script type="text/javascript" charset="utf-8">
        $(document).keydown(function(tecla){
            if (tecla.keyCode == 65) {
                $('.a').css({ 'background-color' : 'red' });
            }else if(tecla.keyCode == 83) {
                $('.s').css({ 'background-color' : 'blue' });
            }else if(tecla.keyCode == 68){
                $('.d').css({ 'background-color' : 'green' });
            }
        });
    </script>
</body>
</html>