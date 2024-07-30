{include common/header@php94/installer}
<div style="display: flex;gap: 10px;">
    <div style="color: gray;">系统简介</div>
    <div style="color: gray;">协议条款</div>
    <div style="color: red;">环境检测</div>
    <div style="color: gray;">初始设置</div>
    <div style="color: gray;">安装完成</div>
</div>
<table style="margin-top: 20px;">
    <thead>
        <tr>
            <th>检测项</th>
            <th>最低要求</th>
            <th>推荐配置</th>
            <th>当前配置</th>
            <th style="width:120px;">检测结果</th>
        </tr>
    </thead>
    <tbody>
        {foreach $envs as $v}
        <tr>
            <td>{$v[0]}</td>
            <td>{$v[1]}</td>
            <td>{$v[2]}</td>
            <td>{$v[3]}</td>
            <td>{echo $v[4]?'<span style="color:green;">通过</span>':'<span style="color:red;">不通过</span>'}</td>
        </tr>
        {/foreach}
    </tbody>
</table>
<table style="margin-top: 20px;">
    <thead>
        <tr>
            <th>检测项</th>
            <th>要求</th>
            <th>当前配置</th>
            <th style="width:120px;">检测结果</th>
        </tr>
    </thead>
    <tbody>
        {foreach $dirfile as $v}
        <tr>
            <td>{$v[1]}</td>
            <td>可写</td>
            <td>{$v[2]}</td>
            <td>{echo $v[3]?'<span style="color:green;">通过</span>':'<span style="color:red;">不通过</span>'}</td>
        </tr>
        {/foreach}
    </tbody>
</table>
<table style="margin-top: 20px;">
    <thead>
        <tr>
            <th>检测项</th>
            <th>要求</th>
            <th>当前配置</th>
            <th style="width:120px;">检测结果</th>
        </tr>
    </thead>
    <tbody>
        {foreach $func as $v}
        <tr>
            <td>{$v[0]}</td>
            <td>支持</td>
            <td>{$v[1]}</td>
            <td>{echo $v[2]?'<span style="color:green;">通过</span>':'<span style="color:red;">不通过</span>'}</td>
        </tr>
        {/foreach}
    </tbody>
</table>
<div style="display: flex;gap: 10px;margin-top: 20px;">
    <form action="{echo $router->build('/php94/installer/license')}">
        <input type="submit" value="上一步">
    </form>
    {if !$env_err}
    <form action="{echo $router->build('/php94/installer/database')}">
        <input type="submit" value="下一步">
    </form>
    {else}
    <form action="{echo $router->build('/php94/installer/database')}">
        <input type="submit" value="系统环境不满足需求，请检查！" disabled>
    </form>
    {/if}
</div>
{include common/footer@php94/installer}