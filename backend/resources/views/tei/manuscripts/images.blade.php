<facsimile>
    @foreach ($manuscript->pages as $page)
        <surface n="{{ $page->folio . $page->page_side }}" xml:id="mysql_id_{{ $page->id }}">
            @foreach ($page->images as $image)
                <graphic @if(isset($image->credit))
                             decls="#imageRights-{{($image->credit)+1}}"
                         @endif
                         @if(isset($image->image_link))
                             url="{{ $image->image_link }}"
                        @endif
                />
            @endforeach
        </surface>
    @endforeach
</facsimile>
