<div class="row">
    <div class="col-12 mb-2">
        <b>Invalid:</b> <br class="d-block d-lg-none" /> {{ ucfirst(str_replace('invalid: ', '', json_decode($transaction->message['bindings'])->status)) }}
    </div>
</div>