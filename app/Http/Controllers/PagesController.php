<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDocs(Request $request)
    {
        $content = \Cache::remember('docs', 1440, function () {
            $content = file_get_contents('https://raw.githubusercontent.com/CounterpartyXCP/Documentation/master/Developers/API.md', 'r');
            $content = str_replace('../', 'https://counterparty.io/', $content);
            $content = str_replace('[TOC]', '', $content);
            $content = str_replace('counterparty-server API', '', $content);
            $content = str_replace('counterparty-cli.md', 'https://github.com/CounterpartyXCP/counterparty-cli', $content);
            $content = str_replace('counterparty_lib.md', 'https://github.com/CounterpartyXCP/counterparty-lib', $content);

            return $content;
        });

        return view('pages.docs', compact('content'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFaq(Request $request)
    {
        $content = \Cache::remember('faqs', 1440, function () {
            $content_one = file_get_contents('https://raw.githubusercontent.com/CounterpartyXCP/Documentation/master/Basics/FAQ-XCP.md', 'r');
            $content_two = file_get_contents('https://raw.githubusercontent.com/CounterpartyXCP/Documentation/master/Basics/FAQ.md', 'r');
            $content = $content_one . "\n\n" . $content_two;
            $content = str_replace('../', 'https://counterparty.io/', $content);
            $content = str_replace('[TOC]', '', $content);
            $content = str_replace('*To learn more about XCP, see [about XCP](FAQ-XCP.md).*', '', $content);
            $content = str_replace('https://counterpartychain.io/transaction/', 'https://xcpfox.com/tx/', $content);
            $content = str_replace('([1CounterpartyXXXXXXXXXXXXXXXUWLpVr](https://xchain.io/burns))', '(1CounterpartyXXXXXXXXXXXXXXXUWLpVr)', $content);
            $content = str_replace('More info on that is [here](/UI/Counterwallet_Tutorials/create_armory_address.md).', '', $content);

            return $content;
        });

        return view('pages.faq', compact('content'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNodeSetup(Request $request)
    {
        $content = \Cache::remember('nodes', 1440, function () {
            $content = file_get_contents('https://raw.githubusercontent.com/CounterpartyXCP/Documentation/master/Installation/federated_node.md', 'r');
            $content = str_replace('../', 'https://counterparty.io/', $content);
            $content = str_replace('Setting up a Counterparty Node', '', $content);

            return $content;
        });

        return view('pages.node-setup', compact('content'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTerms(Request $request)
    {
        return view('pages.terms');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPrivacy(Request $request)
    {
        return view('pages.privacy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDisclaimer(Request $request)
    {
        return view('pages.disclaimer');
    }
}
