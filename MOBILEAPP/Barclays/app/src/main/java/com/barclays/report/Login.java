package com.barclays.report;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.error.VolleyError;
import com.android.volley.request.StringRequest;
import com.barclays.report.global.GlobalVars;
import com.barclays.report.global.MyApplication;
import com.barclays.report.global.VolleySingleton;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class Login extends AppCompatActivity {
    public VolleySingleton volleySingleton;
    public RequestQueue requestQueue;
    private ProgressBar progressBar;

    Context ctx;

    Button btLogin;
    EditText etUsername, etPassword;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login_main);
        //this.getSupportActionBar().hide();

        ctx = Login.this;
        volleySingleton = VolleySingleton.getInstance();
        requestQueue = volleySingleton.getRequestQueue();


        etUsername = (EditText) findViewById(R.id.etUsername);
        etPassword = (EditText) findViewById(R.id.etPassword);
        progressBar=(ProgressBar)findViewById(R.id.progressBar);

        btLogin = (Button) findViewById(R.id.btLogin);


        btLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
//                Intent intentDashboard = new Intent(Login.this, Dashboard.class);
//                startActivity(intentDashboard);
//                finish();
                preValidate();
            }
        });


    }


    private void preValidate() {
//        String strUsername = "admin@admin.com";
//        String strPassword = "password";

        String strUsername = etUsername.getText().toString().trim();
        String strPassword = etPassword.getText().toString().trim();

        if (strUsername.isEmpty()) {
            Toast.makeText(ctx, ctx.getResources().getString(R.string.missing_username), Toast.LENGTH_LONG).show();
        } else if (strPassword.isEmpty()) {
            Toast.makeText(ctx, ctx.getResources().getString(R.string.missing_password), Toast.LENGTH_LONG).show();
        } else {
            Map<String, String> params = new HashMap<>();
            params.put("username", strUsername);
            params.put("password", strPassword);
            Map<String, String> headers = new HashMap<>();
            headers.put("X-Auth-Token", GlobalVars.fung);

            performData(GlobalVars.BASE_URL + "login", params, headers);


        }
    }

    public void performData(String url, Map<String, String> params,Map<String, String> headers) {
        progressBar.setVisibility(View.VISIBLE);
        StringRequest stringRequest = new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String responseString) {
                progressBar.setVisibility(View.GONE);
                try {
                    JSONObject jsonObject = new JSONObject(responseString);
                    parseJSON(jsonObject);
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
                if(!result.getBoolean("error")){
                    MyApplication.USER_LOGIN=etUsername.getText().toString().trim();
                    MyApplication.USER_PASSWORD=etPassword.getText().toString().trim();

                    JSONObject message=result.getJSONObject("message");

                    MyApplication.FIRST_NAME=message.getString("first_name");
                    MyApplication.LAST_NAME=message.getString("last_name");

                    startActivity(new Intent(ctx,Dashboard.class));
                }else{
                    Toast.makeText(ctx, ctx.getResources().getString(R.string.problem_processing), Toast.LENGTH_LONG).show();

                }

            } else {
                Toast.makeText(ctx, ctx.getResources().getString(R.string.problem_processing), Toast.LENGTH_LONG).show();
            }

        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
