package com.barclays.report;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.res.Configuration;
import android.content.res.TypedArray;
import android.os.Bundle;
import android.support.v4.app.ActionBarDrawerToggle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.widget.DrawerLayout;
import android.support.v4.widget.ViewDragHelper;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.Gravity;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.ProgressBar;
import android.widget.TextView;


import com.applozic.mobicomkit.api.account.register.RegistrationResponse;
import com.applozic.mobicomkit.api.account.user.User;
import com.applozic.mobicomkit.api.account.user.UserLoginTask;
import com.applozic.mobicomkit.uiwidgets.ApplozicSetting;
import com.applozic.mobicomkit.uiwidgets.conversation.activity.ConversationActivity;
import com.barclays.report.adapters.NavDrawerListAdapter;
import com.barclays.report.global.Fonting;
import com.barclays.report.global.MyApplication;
import com.barclays.report.models.NavDrawerItem;

import java.lang.reflect.Field;
import java.util.ArrayList;

public class Dashboard extends AppCompatActivity {

    Context ctx = Dashboard.this;
    public static boolean isHome = false;
    private UserLoginTask mAuthTask = null;

    DrawerLayout drawerLayout;
    private ListView mDrawerList;
    private ActionBarDrawerToggle mDrawerToggle;
    private CharSequence mDrawerTitle;
    private CharSequence mTitle;
    private String[] navMenuTitles;
    private String[] navMenuTitles_desc;
    private TypedArray navMenuIcons;
    private ArrayList<NavDrawerItem> navDrawerItems;
    private NavDrawerListAdapter adapter;

    ImageView appImage;
    TextView TitleText;
    public ProgressBar progressBar;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_dashboard);


        //drawer stuff
        drawerLayout = (DrawerLayout) findViewById(R.id.drawerLayout);
        mDrawerList = (ListView) findViewById(R.id.left_drawer);
        // appImage = (ImageView) findViewById(android.R.id.home);
        TitleText = (TextView) findViewById(android.R.id.title);

        progressBar=(ProgressBar)findViewById(R.id.progressBar);

        try {

            Field mDragger = drawerLayout.getClass().getDeclaredField("mLeftDragger");//mRightDragger for right obviously
            mDragger.setAccessible(true);
            ViewDragHelper draggerObj = (ViewDragHelper) mDragger.get(drawerLayout);

            Field mEdgeSize = draggerObj.getClass().getDeclaredField("mEdgeSize");
            mEdgeSize.setAccessible(true);
            int edge = mEdgeSize.getInt(draggerObj);
            mEdgeSize.setInt(draggerObj, edge * 10);
        } catch (Exception e) {
            e.printStackTrace();
        }

        Fonting.setTypeFaceForViewGroup((ViewGroup) mDrawerList.getRootView(), ctx,
                Fonting.KEY_LIGHT);
        // toolBar = (Toolbar) findViewById(R.id.toolbar);
        //Toolbar will now take on default actionbar characteristics
        // setSupportActionBar(toolBar);
//        getSupportActionBar().setTitle("test");
        getSupportActionBar().setIcon(R.drawable.ic_drawer);
        getSupportActionBar().setTitle("BARCLAYS BANK");
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);


        mTitle = mDrawerTitle = getTitle();
        navMenuTitles = getResources().getStringArray(R.array.nav_drawer_items);
        navMenuTitles_desc = getResources().getStringArray(R.array.nav_drawer_items_desc);
        navMenuIcons = getResources()
                .obtainTypedArray(R.array.nav_drawer_icons);

        navDrawerItems = new ArrayList<NavDrawerItem>();
        navDrawerItems.add(new NavDrawerItem(navMenuTitles[0], navMenuTitles_desc[0], navMenuIcons
                .getResourceId(0, -1)));

        navDrawerItems.add(new NavDrawerItem(navMenuTitles[1], navMenuTitles_desc[1], navMenuIcons
                .getResourceId(1, -1)));

        navDrawerItems.add(new NavDrawerItem(navMenuTitles[2], navMenuTitles_desc[2], navMenuIcons
                .getResourceId(2, -1)));

        navDrawerItems.add(new NavDrawerItem(navMenuTitles[3], navMenuTitles_desc[3], navMenuIcons
                .getResourceId(3, -1)));
        navDrawerItems.add(new NavDrawerItem(navMenuTitles[4], navMenuTitles_desc[4], navMenuIcons
                .getResourceId(4, -1)));




        navMenuIcons.recycle();
        adapter = new NavDrawerListAdapter(getApplicationContext(), navDrawerItems);

        mDrawerList.setAdapter(adapter);
        mDrawerList.setOnItemClickListener(new SlideMenuClickListener());
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeAsUpIndicator(R.drawable.ic_drawer);
        getSupportActionBar().setHomeButtonEnabled(true);
        mDrawerToggle = new ActionBarDrawerToggle(this, drawerLayout, R.drawable.ic_drawer, R.string.app_name, R.string.app_name) {

            @Override
            public void onDrawerClosed(View view) {
                getSupportActionBar().setTitle(mTitle);
                invalidateOptionsMenu();
            }

            @Override
            public void onDrawerOpened(View drawerView) {
//                getSupportActionBar().setTitle(getResources().getString(R.string.menu));
                invalidateOptionsMenu();
            }

        };

        drawerLayout.setDrawerListener(mDrawerToggle);


        if (savedInstanceState == null) {
            try {
                String menuFragment = getIntent().getStringExtra("pingsFragment");
                if (menuFragment != null) {
                    if (menuFragment.equals("showPings")) {
                        displayView(1);
                    } else {
                        displayView(0);
                    }
                } else {
                    displayView(0);
                }

            } catch (Exception e) {
                e.printStackTrace();
            }
        }


        //end drawer stuff
    }

    //Cloud messaging Manenos
    @Override
    protected void onResume() {
        super.onResume();

    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {

        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.dashboard, menu);
        //menu.findItem(R.id.action_settings).setVisible(false);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        if (mDrawerToggle.onOptionsItemSelected(item)) {
            return true;
        }

        switch (item.getItemId()) {

//            case R.id.action_share:
//                onInviteClicked();
//                drawerLayout.closeDrawers();
//                return true;
//            case R.id.action_emergency:
//                Intent emergency = new Intent(ctx, Dashemer.class);
//                startActivity(emergency);
//                drawerLayout.closeDrawers();
//                return true;

            default:
                drawerLayout.closeDrawers();
                return super.onOptionsItemSelected(item);


        }

    }

    @Override
    public boolean onPrepareOptionsMenu(Menu menu) {
//		boolean drawerOpen = mDrawerLayout.isDrawerOpen(mDrawerList);
//		menu.findItem(R.id.action_settings).setVisible(!drawerOpen);
        return super.onPrepareOptionsMenu(menu);

    }

    @Override
    public void setTitle(CharSequence title) {
        mTitle = title;
        getSupportActionBar().setTitle(mTitle);

    }

    @Override
    protected void onPostCreate(Bundle savedInstanceState) {
        super.onPostCreate(savedInstanceState);
        mDrawerToggle.syncState();
    }

    @Override
    public void onConfigurationChanged(Configuration newConfig) {
        super.onConfigurationChanged(newConfig);
        mDrawerToggle.onConfigurationChanged(newConfig);

    }


    private class SlideMenuClickListener implements
            ListView.OnItemClickListener {

        @Override
        public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
            displayView(position);
        }
    }


    private void displayView(int position) {
        Fragment fragment = null;

        switch (position) {

            case 0:
                isHome = true;
                fragment = new Home();
                break;

            case 1:
                isHome = false;
                fragment = new Report();
                break;

            case 2:
                isHome = false;
                fragment = new Leads();
                break;
            case 3:
                isHome = false;
                ingia();
                break;

            case 4:
                isHome = false;
                finish();
                break;

            default:
                isHome = false;
                break;

        }

        if (fragment != null) {

            FragmentManager fragmentManager = getSupportFragmentManager();

            fragmentManager.beginTransaction()
                    .replace(R.id.container, fragment).commit();

            mDrawerList.setItemChecked(position, true);
            mDrawerList.setSelection(position);
            getSupportActionBar().setTitle(navMenuTitles[position]);
            drawerLayout.closeDrawer(Gravity.LEFT);

        } else {
            Log.e("Help", "Error in creating fragment");

        }

    }


    @Override
    public void onBackPressed() {
        if (isHome) {
            finish();
        } else {
            displayView(0);
        }

        // finish();
    }

    public void ingia() {
        progressBar.setVisibility(View.VISIBLE);
        UserLoginTask.TaskListener listener = new UserLoginTask.TaskListener() {


            @Override
            public void onSuccess(RegistrationResponse registrationResponse, final Context context) {
                progressBar.setVisibility(View.GONE);
                mAuthTask = null;
                ApplozicSetting.getInstance(context).showStartNewButton().showPriceOption();

                //Basic settings...

                //ApplozicSetting.getInstance(context).hideConversationContactImage().hideStartNewButton().hideStartNewFloatingActionButton();

                ApplozicSetting.getInstance(context).showStartNewGroupButton()
                        .setCompressedImageSizeInMB(5)
                        .enableImageCompression()
                        .setMaxAttachmentAllowed(5);

//                //Start GCM registration....
//                GCMRegistrationUtils gcmRegistrationUtils = new GCMRegistrationUtils(activity);
//                gcmRegistrationUtils.setUpGcmNotification();
//
//                buildContactData();


                new Thread(new Runnable() {
                    @Override
                    public void run() {
                        new ContactsSync(ctx).syncData();
                    }
                }).start();


                Intent intent = new Intent(context, ConversationActivity.class);
                startActivity(intent);
                finish();
            }

            @Override
            public void onFailure(RegistrationResponse registrationResponse, Exception exception) {
                mAuthTask = null;
                progressBar.setVisibility(View.GONE);

                android.support.v7.app.AlertDialog alertDialog = new android.support.v7.app.AlertDialog.Builder(ctx).create();
                alertDialog.setTitle("titile");
                alertDialog.setMessage(exception.toString());
                alertDialog.setButton(android.support.v7.app.AlertDialog.BUTTON_NEUTRAL, getString(android.R.string.ok),
                        new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int which) {
                                dialog.dismiss();
                            }
                        });
                if (!isFinishing()) {
                    alertDialog.show();
                }
            }
        };

        User user = new User();
        user.setUserId(MyApplication.USER_LOGIN);
        user.setPassword(MyApplication.USER_PASSWORD);
        user.setDisplayName(MyApplication.FIRST_NAME+" "+MyApplication.LAST_NAME);

        mAuthTask = new UserLoginTask(user, listener, this);
        mAuthTask.execute((Void) null);

    }

}
