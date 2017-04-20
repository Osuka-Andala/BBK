package com.barclays.report.global;

import android.app.Application;
import android.content.Context;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;

import com.crashlytics.android.Crashlytics;

import io.fabric.sdk.android.Fabric;

/**
 * Created by francis on 13/09/2015.
 */
public class MyApplication extends android.support.multidex.MultiDexApplication {
    private static final String TAG = MyApplication.class.getSimpleName();

    public static final String APP_ID = "35894";
    public static final String AUTH_KEY = "vdwxpPk8pc9G4fE";
    public static final String AUTH_SECRET = "kQpk-N9adgbgqpP";
    public static final String ACCOUNT_KEY = "o7CVuX5vLXM1UYQfzzoe";

    public static final String STICKER_API_KEY = "a19e1120ef6be5d5e8b199accaa7035c";

    public static  String USER_LOGIN = "";
    public static  String USER_PASSWORD = "";
    public static  String FIRST_NAME="";
    public static  String LAST_NAME="";

    //call stuff
    public static final String VERSION_NUMBER = "1.0";

    public static final int CALL_ACTIVITY_CLOSE = 1000;

    //CALL ACTIVITY CLOSE REASONS
    public static final int CALL_ACTIVITY_CLOSE_WIFI_DISABLED = 1001;
    public static final String WIFI_DISABLED = "wifi_disabled";

    public final static String OPPONENTS = "opponents";
    public static final String CONFERENCE_TYPE = "conference_type";

    public static MyApplication sInstance;

    @Override
    public void onCreate() {
        super.onCreate();
        Fabric.with(this, new Crashlytics());
        sInstance = this;

    }

    public int getAppVersion() {
        try {
            PackageInfo packageInfo = getPackageManager().getPackageInfo(getPackageName(), 0);
            return packageInfo.versionCode;
        } catch (PackageManager.NameNotFoundException e) {
            // should never happen
            throw new RuntimeException("Could not get package name: " + e);
        }
    }


    public static MyApplication getInstance() {
        return sInstance;
    }

    public static Context getAppContext() {
        return sInstance.getApplicationContext();
    }
}
