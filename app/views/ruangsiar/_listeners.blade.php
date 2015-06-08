
@{{#each data}}
<tr>
    <td><a class="btn-liked-member" data-id="@{{facebook_id}}" href="#">@{{name}}</a> <small class="pull-right text-muted timeago" title="@{{created_at}}">@{{created_at}}</small></td>
</tr>
@{{/each}}