@{{#each data}}
<tr>
    <td>@{{nama}}, @{{instansi}}</td>
    <td><a class="btn-view" href="#" data-id="@{{id}}">view</a></td>
    <td>@{{type}}</td>
    <td>@{{count}}</td>
</tr>
@{{/each}}