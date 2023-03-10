<div>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Mail Variables</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Mail Variables</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <button type="button" class="btn btn-secondary create-btn" style="float: left"
                                    wire:click="$emit('showCreateModal')"><i class="fa fa-plus"></i> Create</button>
                            </div>
                            <!-- /.card-header -->
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="card">
                                            <div class="card-header">Edit Mail Template</div>
                                            <div class="card-body">

                                                <form method="post" wire:submit.prevent="submit({{ $itemId }})">

                                                    @csrf

                                                    <div class="form-group">
                                                        <label>Title</label>
                                                        <input type="text"
                                                            class="form-control @error('title') is-invalid @endif" name="title" wire:model.lazy="title" />
                                                        @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                                    </div>
                            
                                                    <div class="form-group">
                                                        <label>Template Key</label>
                                                        <input type="text"
                                                            class="form-control @error('key') is-invalid @endif" name="key" wire:model.lazy="key" />
                                                        @error('key') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                                    </div>
                            
                                                    <div class="form-group">
                                                        <label>Subject</label>
                                                        <input type="text"
                                                            class="form-control @error('subject') is-invalid @endif" name="subject" wire:model.lazy="subject" />
                                                        @error('subject') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                                    </div>
                            
                                                    <div class="form-group"
                                                            wire:ignore>
                                                        <label>Email Content</label>

                                                        @include('backend.partials.mail-variables')

                                                        <textarea class="form-control" name="body" id="editor">{{ $body }}</textarea>
                                                        @error('body')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="d-grid gap-2 mt-2">
                                                        <input type="submit" class="btn btn-primary" value="Update" />
                                                    </div>

                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        @include('backend.partials.template-preview')
                                    </div>
                                </div>

                                @push('extra-js')
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.3.2/tinymce.min.js"
                                        integrity="sha512-0hADhKU8eEFSmp3+f9Yh8QmWpr6nTYLpN9Br7k2GTUQOT6reI2kdEOwkOORcaRZ+xW5ZL8W24OpBlsCOCqNaNQ=="
                                        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                                    <script>
                                        function initializeTinymce(onchange) {
                                            window.onload = () => {
                                                tinymce.init({
                                                    selector: '#editor',
                                                    plugins: 'print fullpage preview code powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker textpattern noneditable help formatpainter permanentpen pageembed charmap tinycomments mentions quickbars linkchecker emoticons advtable export',
                                                    menubar: 'file edit view insert format tools table tc help',
                                                    toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
                                                    autosave_ask_before_unload: true,
                                                    image_advtab: true,
                                                    height: 600,
                                                    image_caption: true,
                                                    toolbar_mode: 'sliding',
                                                    contextmenu: 'link image imagetools table configurepermanentpen',
                                                    setup: (ed) => {
                                                        ed.on('change', (e) => onchange(ed.getContent()));
                                                    }
                                                });

                                            }
                                        };
                                    </script>
                                    <script>
                                        initializeTinymce((content) => @this.set('body', content));
                                    </script>
                                @endpush

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    @push('extra-js')
        <script type="text/javascript" src="{{ asset('backend/plugins/tinymce/tinymce-6.3.2.min.js') }}"></script>

        <script>
            initializeTinymce((content) => @this.set('body', content));
        </script>
        <!-- AdminLTE App -->
        <script src="{{ asset('backend/dist/js/sweetalert.min.js') }}"></script>
        <!-- bs-custom-file-input -->
        <script src="{{ asset('backend/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

        <script>
            function initializeTinymce(onchange) {
                window.onload = () => {
                    tinymce.init({
                        selector: '#editor',
                        plugins: 'print fullpage preview code powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker textpattern noneditable help formatpainter permanentpen pageembed charmap tinycomments mentions quickbars linkchecker emoticons advtable export',
                        menubar: 'file edit view insert format tools table tc help',
                        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
                        autosave_ask_before_unload: true,
                        image_advtab: true,
                        height: 600,
                        image_caption: true,
                        toolbar_mode: 'sliding',
                        contextmenu: 'link image imagetools table configurepermanentpen',
                        setup: (ed) => {
                            ed.on('change', (e) => onchange(ed.getContent()));
                        }
                    });

                }
            };
        </script>
    @endpush
</div>
