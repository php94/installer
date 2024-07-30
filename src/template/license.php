{include common/header@php94/installer}
<div style="display: flex;gap: 10px;">
    <div style="color: gray;">系统简介</div>
    <div style="color: red;">协议条款</div>
    <div style="color: gray;">环境检测</div>
    <div style="color: gray;">初始设置</div>
    <div style="color: gray;">安装完成</div>
</div>
<div style="max-height: 300px;overflow-y: auto;border: 1px solid #ff0000;background: yellow;padding: 10px;margin-top: 20px;">
    <pre>{echo $license}</pre>
</div>
<div style="display: flex;gap: 10px;margin-top: 20px;">
    <form action="{echo $router->build('/php94/installer/readme')}">
        <input type="submit" value="我不同意该协议">
    </form>
    <form action="{echo $router->build('/php94/installer/check')}">
        <input type="submit" onclick="return confirm('此协议具有法律效应，请认真阅读！！\r\n进入下一步代表您同意该协议条款\r\n不同意请立即停止安装！');" value="我同意该协议">
    </form>
</div>
{include common/footer@php94/installer}