<a href="#" class="content-menu-toggle btn btn-primary"><i class="material-symbols-outlined">menu</i> content</a>
<div class="content-menu content-menu-right">
    <ul class="list-unstyled">
        <li><a href="<?php echo BASE_URL . 'Archivos'; ?>" class="<?php echo ($data['active'] == 'todos') ? 'active' : 'b' ; ?>">Todos</a></li>
        <li><a href="<?php echo BASE_URL . 'admin'; ?>" class="<?php echo ($data['active'] == 'recientes') ? 'active' : 'b' ; ?>">Recientes</a></li>
        <li><a href="#" class="<?php echo ($data['active'] == 'deleted') ? 'active' : 'b' ; ?>">Eliminados</a></li>
        <li class="divider"></li>
        <li><a href="#" class="<?php echo ($data['active'] == 'shared') ? 'active' : 'b' ; ?>">Compartidos</a></li>
    </ul>
</div>

