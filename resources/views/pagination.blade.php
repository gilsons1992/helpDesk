<input type="hidden" id="pagina" value="{{$pagina}}">
<input type="hidden" id="primeiraPaginaPaginador" value="{{$primeiraPaginaPaginador}}">
<div class="card-footer">
    <div class="row">                    
        <div class="col-9">                        
            <nav aria-label="Navegação de páginas">
                <ul class="pagination">
                    @if ($pagina > 1)
                        <li class="page-item">                                    
                        <a class="page-link" href="javascript:setPage('1');javascript:setFirstPage('1');javascript:loadRecords('{{$entity}}');" aria-label="Primeiro">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Primeiro</span>
                        </a>
                        </li>
                    @endif
                    @if ($primeiraPaginaPaginador > 1)
                        <li class="page-item"><a class="page-link" href="javascript:setPage('{{$primeiraPaginaPaginador-1}}');javascript:setFirstPage('{{$primeiraPaginaPaginador-1}}');javascript:loadRecords('{{$entity}}')">...</a></li>
                    @endif
                    @for($i = $primeiraPaginaPaginador; $i <= $qtPaginas; $i++)
                        @if ($i - $primeiraPaginaPaginador < 10)
                            <li class="page-item">
                                <a class="page-link" 
                                @if ($i == $pagina)
                                    style="pointer-events: none;cursor: default; background-color:yellow;"
                                @endif
                                href="javascript:setPage('{{$i}}');javascript:loadRecords('{{$entity}}');">{{$i}}</a></li>
                        @else
                            <li class="page-item"><a 
                                class="page-link" 
                                href="javascript:setPage('{{$i}}');javascript:setFirstPage('{{$i}}');javascript:loadRecords('{{$entity}}')">...</a></li>
                            @break                                        
                        @endif

                    @endfor
                    <li class="page-item">
                    <a class="page-link" href="javascript:setFirstPage('{{$qtPaginas}}');javascript:setPage('{{$qtPaginas}}');javascript:loadRecords('{{$entity}}');" aria-label="Último">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Último</span>
                    </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="col-3 text-right">
            @if ($qtRegistros > 0)
              Mostrando {{$primeiro}} a {{$ultimo}} de {{$qtRegistros}}
            @else
              Nenhum registro encontrado
            @endif
        </div>
    </div>
</div>
