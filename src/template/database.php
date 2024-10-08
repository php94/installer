{include common/header@php94/installer}
<div style="display: flex;gap: 10px;">
    <div style="color: gray;">系统简介</div>
    <div style="color: gray;">协议条款</div>
    <div style="color: gray;">环境检测</div>
    <div style="color: red;">初始设置</div>
    <div style="color: gray;">安装完成</div>
</div>
<form action="{echo $router->build('/php94/installer/database')}" method="POST">
    <table style="margin-top: 20px;">
        <tr>
            <td>
                数据库地址：
            </td>
            <td>
                <input type="text" name="database_server" value="127.0.0.1" required>
            </td>
            <td>
                <small>通常是127.0.0.1</small>
            </td>
        </tr>
        <tr>
            <td>
                数据库端口：
            </td>
            <td>
                <input type="text" name="database_port" value="3306" required>
            </td>
            <td>
                <small>通常是3306</small>
            </td>
        </tr>
        <tr>
            <td>
                数据库帐号：
            </td>
            <td>
                <input type="text" name="database_username" value="root" required>
            </td>
            <td>
            </td>
        </tr>
        <tr>
            <td>
                数据库密码：
            </td>
            <td>
                <input type="text" name="database_password" value="root">
            </td>
            <td>
            </td>
        </tr>
        <tr>
            <td>
                数据库名称：
            </td>
            <td>
                <input type="text" name="database_name" value="" required>
            </td>
            <td>
                <small>本安装程序不会创建数据库，请先手动创建（mysql, utf8mb4）~</small>
            </td>
        </tr>
        <tr>
            <td>
                是否安装演示数据：
            </td>
            <td>
                <label>
                    <input type="radio" name="demo" value="0" checked>
                    不安装
                </label>
                <label>
                    <input type="radio" name="demo" value="1">
                    安装
                </label>
            </td>
            <td>
                <small>演示数据请勿用于正式项目~</small>
            </td>
        </tr>
    </table>
    <div style="display: flex;gap: 10px;margin-top: 20px;">
        <input type="button" onclick="history.back()" value="上一步">
        <input type="submit" value="安装">
    </div>
</form>
{include common/footer@php94/installer}