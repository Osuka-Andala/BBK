package com.barclays.report;


import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;

import com.applozic.mobicomkit.api.account.register.RegistrationResponse;
import com.applozic.mobicomkit.api.account.user.User;
import com.applozic.mobicomkit.api.account.user.UserLoginTask;
import com.applozic.mobicomkit.uiwidgets.ApplozicSetting;
import com.applozic.mobicomkit.uiwidgets.conversation.activity.ConversationActivity;


/**
 * A simple {@link Fragment} subclass.
 */
public class Chat extends Fragment {
    Button btChat,btVideo;
    Context ctx;
    private UserLoginTask mAuthTask = null;



    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View v = inflater.inflate(R.layout.fragment_chat, container, false);
        setHasOptionsMenu(true);

        ctx = container.getContext();

        btChat=(Button)v.findViewById(R.id.btChat);
        btVideo=(Button)v.findViewById(R.id.btVideo);

//        btChat.setOnClickListener(new View.OnClickListener() {
//            @Override
//            public void onClick(View v) {
//                Intent intent = new Intent(ctx, SplashActivity.class);
//                startActivity(intent);
//            }
//        });
//        btVideo.setOnClickListener(new View.OnClickListener() {
//            @Override
//            public void onClick(View v) {
//                Intent intent = new Intent(ctx, ListUsersActivity.class);
//                startActivity(intent);
//            }
//        });


        // Inflate the layout for this fragment
        return v;
    }



}
