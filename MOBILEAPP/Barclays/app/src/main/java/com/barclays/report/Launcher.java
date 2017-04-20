package com.barclays.report;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.ProgressBar;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.error.VolleyError;
import com.android.volley.request.StringRequest;
import com.applozic.mobicomkit.api.account.register.RegistrationResponse;
import com.applozic.mobicomkit.api.account.user.User;
import com.applozic.mobicomkit.api.account.user.UserLoginTask;
import com.applozic.mobicomkit.contact.AppContactService;
import com.applozic.mobicomkit.uiwidgets.ApplozicSetting;
import com.applozic.mobicomkit.uiwidgets.conversation.activity.ConversationActivity;
import com.applozic.mobicommons.people.contact.Contact;
import com.barclays.report.global.GlobalVars;
import com.barclays.report.global.VolleySingleton;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class Launcher extends AppCompatActivity {
    public VolleySingleton volleySingleton;
    public RequestQueue requestQueue;
    private ProgressBar progressBar;
    Context ctx;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_launcher);
        this.getSupportActionBar().hide();
        ctx = Launcher.this;
        volleySingleton = VolleySingleton.getInstance();
        requestQueue = volleySingleton.getRequestQueue();
        progressBar = (ProgressBar) findViewById(R.id.progressBar);
        preValidate();
    }

    private void preValidate() {
//        String strUsername = "admin@admin.com";
//        String strPassword = "password";
        Map<String, String> params = new HashMap<>();
        params.put("", "");
        Map<String, String> headers = new HashMap<>();
        headers.put("X-Auth-Token", GlobalVars.fung);

        performData(GlobalVars.BASE_URL + "predata/all", params, headers);
    }

    public void performData(String url, Map<String, String> params, Map<String, String> headers) {
        progressBar.setVisibility(View.VISIBLE);
        StringRequest stringRequest = new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String responseString) {
                progressBar.setVisibility(View.GONE);
                try {
                    JSONObject jsonObject = new JSONObject(responseString);
                    parseJSON(jsonObject.getJSONObject("message"));
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                progressBar.setVisibility(View.GONE);
                Toast.makeText(ctx, error.toString(), Toast.LENGTH_LONG).show();
            }
        });
        stringRequest.setParams(params);
        stringRequest.setHeaders(headers);
        requestQueue.add(stringRequest);
    }

    public void parseJSON(JSONObject result) {
        try {
            if (result.length() > 0) {
                GlobalVars.branches = result.getJSONArray("branches");
                GlobalVars.counties = result.getJSONArray("counties");
                GlobalVars.devices = result.getJSONArray("devices");
                GlobalVars.merchants = result.getJSONArray("merchants");
                GlobalVars.products = result.getJSONArray("products");

                Intent intentDashboard = new Intent(Launcher.this,
                        Login.class);

                startActivity(intentDashboard);
                finish();
            } else {
                Toast.makeText(ctx, ctx.getResources().getString(R.string.problem_processing), Toast.LENGTH_LONG).show();
                finish();
            }

        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
