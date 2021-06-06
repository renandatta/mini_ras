<div id="tree_feature" class="tree-demo mb-5" style="overflow-x: scroll;">
</div>

@push('styles')
    <link href="{{ asset('assets/plugins/jstree/jstree.bundle.css?v=7.0.9') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('assets/plugins/jstree/jstree.bundle.js?v=7.0.9') }}"></script>
    <script>
        let $tree_feature = $('#tree_feature');
        $tree_feature.jstree({
            core: {
                themes: { responsive: false },
                check_callback: true,
                data: [],
            },
            types: {
                default: {
                    icon: "fa fa-folder text-primary"
                },
            },
            plugins: ["types"],
        }).on("refresh.jstree", function () {
            $(this).jstree("open_all");
        }).on("select_node.jstree", function (e, data) {
            info_feature(data.node.original.id);
        });
        let search_features = () => {
            $.post("{{ route('admin.features.search') }}", {
                _token
            }, (result) => {
                $tree_feature.jstree(true).settings.core.data = result;
                $tree_feature.jstree(true).refresh(true);
            }).fail((xhr) => {
                console.log(xhr.responseText);
            });
        }
    </script>
@endpush
