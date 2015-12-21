<div class="file-input-container single">
    <div class="form-group">
        <label for="image" class="col-sm-2 control-label">{{ $label }}</label>
        <div class="col-sm-10 single-input">
            <label class="label-file" for="{{ $name }}">
                <span id="file-text-{{ $name }}" class="file-source">Attachments, click to add file</span>
                <i class="icon-file-input pull-right"></i>
            </label>

            <input type="file" name="{{ $name }}" id="{{ $name }}" class="form-control file-input" data-file-text="#file-text-{{ $name }}">
        </div>
    </div>
</div>
