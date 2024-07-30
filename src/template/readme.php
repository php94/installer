{include common/header@php94/installer}
<div style="display: flex;gap: 10px;">
    <div style="color: red;">系统简介</div>
    <div style="color: gray;">协议条款</div>
    <div style="color: gray;">环境检测</div>
    <div style="color: gray;">初始设置</div>
    <div style="color: gray;">安装完成</div>
</div>
<script src="{echo $router->build('/php94/installer/file', ['file'=>'mdjs'])}"></script>
<div id="readme" style="max-height: 300px;overflow-y: auto;border: 1px solid #ff0000;background: yellow;padding: 10px;margin-top: 20px;"></div>
<script>
    function base64Decode(input) {
        rv = window.atob(input);
        rv = escape(rv);
        rv = decodeURIComponent(rv);
        return rv;
    }
    var md = window.markdownit();
    var readme = document.getElementById("readme");
    readme.innerHTML = md.render(base64Decode("{:base64_encode($readme)}"));
</script>
<div style="display: flex;gap: 10px;margin-top: 20px;">
    <form action="{echo $router->build('/php94/installer/license')}">
        <input type="submit" value="下一步">
    </form>
</div>
{include common/footer@php94/installer}