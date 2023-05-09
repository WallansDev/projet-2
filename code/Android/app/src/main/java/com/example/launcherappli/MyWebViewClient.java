package com.example.launcherappli;

import android.os.Build;
import android.webkit.WebResourceRequest;
import android.webkit.WebView;
import android.webkit.WebViewClient;

public class MyWebViewClient extends WebViewClient {
    @Override
    public boolean shouldOverrideUrlLoading(WebView view, WebResourceRequest request) {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.N) {
            view.loadUrl(request.getUrl().toString());
        } else {
            view.loadUrl(request.toString());
        }
        return true;
    }
}


