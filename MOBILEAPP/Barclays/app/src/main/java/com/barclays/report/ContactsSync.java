package com.barclays.report;

import android.content.Context;
import android.content.Intent;
import android.view.View;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.error.VolleyError;
import com.android.volley.request.StringRequest;
import com.applozic.mobicomkit.api.people.ChannelCreate;
import com.applozic.mobicomkit.channel.service.ChannelService;
import com.applozic.mobicomkit.contact.AppContactService;
import com.applozic.mobicommons.people.channel.Channel;
import com.applozic.mobicommons.people.contact.Contact;
import com.barclays.report.global.GlobalVars;
import com.barclays.report.global.VolleySingleton;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

/**
 * Created by francis on 29/03/2016.
 */
public class ContactsSync {
    public VolleySingleton volleySingleton;
    public RequestQueue requestQueue;
    public Context ctx;

    public ContactsSync(Context ctx) {
        this.ctx = ctx;
        volleySingleton = VolleySingleton.getInstance();
        requestQueue = volleySingleton.getRequestQueue();


    }

    public void syncData() {
        Map<String, String> params = new HashMap<>();
        params.put("", "");

        Map<String, String> headers = new HashMap<>();
        headers.put("X-Auth-Token", GlobalVars.fung);

        performData(GlobalVars.BASE_URL + "predata/members", params, headers);


    }

    public void performData(String url, Map<String, String> params, Map<String, String> headers) {
        StringRequest stringRequest = new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String responseString) {
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
                System.out.println(error.toString());
            }
        });
        stringRequest.setParams(params);
        stringRequest.setHeaders(headers);
        requestQueue.add(stringRequest);
    }

    public void parseJSON(JSONObject result) {
        try {
            if (result.length() > 0) {
                GlobalVars.members = result.getJSONArray("members");
                int length = GlobalVars.members.length();

                if (GlobalVars.members != null) {
                    AppContactService appContactService = new AppContactService(ctx);
                    String groupName = "All Barclays Members Group"; // Name of group.
                    List<String> groupMemberList = new ArrayList<String>();
                    for (int i = 0; i < length; i++) {
                        Contact contact = new Contact();
                        contact.setUserId(GlobalVars.members.getJSONObject(i).getString("staff_id"));
                        contact.setFullName(GlobalVars.members.getJSONObject(i).getString("first_name") + " " + GlobalVars.members.getJSONObject(i).getString("last_name"));
//                        contact.setImageURL(GlobalVars.members.getJSONObject(i).getString("image_url"));
                        contact.setEmailId(GlobalVars.members.getJSONObject(i).getString("email"));
                        appContactService.add(contact);
                        System.out.println("synching contact" + i + "out of" + length);

                        groupMemberList.add(GlobalVars.members.getJSONObject(i).getString("staff_id"));
                    }
                    ChannelCreate channelCreate = new ChannelCreate(groupName, groupMemberList);
                    Channel channel = ChannelService.getInstance(ctx).createChannel(channelCreate); // Instantiating the  group create and it accept the ChannelCreate object.
                }

            } else {
                System.out.println("empty json result");
            }

        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
