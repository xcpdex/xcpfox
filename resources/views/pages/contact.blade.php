@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<div class="container mt-1">
    <h1>Contact</h1>
    <div class="card mt-4">
        <div class="card-header">
            Contact Info
        </div>
        <div class="card-body">
            <p class="card-text">We are unable to help with support requests that are not specific to XCP FOX itself.</p>
            <p class="card-text">For general Counterparty support, please try the different community chat rooms:</p>
            <ul>
                <li><a href="https://discord.gg/fFg9Hmt" target="_blank">Discord</a></li>
                <li><a href="http://slack.counterparty.io/" target="_blank">Slack</a></li>
                <li><a href="https://t.me/counterparty_xcp" target="_blank">Telegram</a></li>
            </ul>
            <p class="card-text">For inquiries and suggestions about XCP FOX, please email us at <a href="mailto:info@xcpfox.com">info@xcpfox.com</a>.</p>
            <p class="card-text">We're also active on Telegram:</p>
            <ul>
                <li><a href="https://t.me/xcpfox" target="_blank">Join our Telegram chat!</a></li>
            </ul>
            <p class="card-text">Thank you for your understanding, as we slowly grow our support capacity further.</p>
        </div>
    </div>
    @include('layouts.cta')
</div>
@endsection
