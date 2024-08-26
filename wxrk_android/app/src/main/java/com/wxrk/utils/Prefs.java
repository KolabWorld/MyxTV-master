package com.wxrk.utils;

import static android.content.Context.MODE_PRIVATE;

import android.content.Context;
import android.content.SharedPreferences;
import android.preference.PreferenceManager;
import android.util.Log;

public class Prefs {


    private static final String TAG = "Prefs";
    private static final String Token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNjI2YjZkMzk1OWEyYThhN2M4NDZmM2I0MjUzNjBiOGUyN2VlYjVkYjAzYmEwZTMwNjFmNTg2OTJhMWFlYjBjZmMwMjRhOWUzZjAwMjg0ZmIiLCJpYXQiOjE2NjAwNDM5OTgsIm5iZiI6MTY2MDA0Mzk5OCwiZXhwIjoxNjkxNTc5OTk4LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.C7cq54vT_hfspDUFiS1AWEJPz5sd-0ptMyBjtMLrheaKlPyrXKDC-EdseJvLWb7V_ccB4vZmpkFrjF9ErHGnvrFa3a9yPrUGWyf_a3v2ayMBQzFIgz1yCnVlsUSchu82mm9aXwq1KNLlCmLNnu03eGBk2SSlv2OnziHfwwRLp3B7nYvIfq4ZNuGbcKyjRGURQ8u8Cw58BiQV9MVxzoaK_7mBiO_9IB_1FMsuu0s38D6numVsp2MOYUe7o4n9My77ILw4f7Nj--2O6pFWwJbfn8_4iSKkrysxcGWU7VOgguctkO1jiagf9ABh5vf1-n-tZfsLadaGe7-H3IDxfLip-lZD_ZRBY7UJItsCmCIwvoCjJK6qr6GJY_VNiOGpOkCh8nDkFlMuHGFO0mLsab8Hg9oj3tc2FOwLDN-vCCKtD-5DBGBGjRA8lpe6xW2RDr5QpWZoHPCDZ9AvO68DXD4129bb8jjPOWSprmlG_1G3skpXMuN6gk3c_fA-WtNz6y0uUsGtn7AWfr_fo-wmu0HbwU83tZm6XQggSqJoaIa6rLGlGrcUirFw0Cn9vNAOaIMERFLlt0Pw9SxK76DrYIFEI1SaWf6OCk4ueuZ_jclphM6z7T4SVOYz2gyOe-FdolMEa2JaMOCgnfiDZpJMy4gyyBs2FLcaR6w4Okg52b37lpU";
    private static final String PREF_NAME = "Pref";
    public static final String MEDIA_FOLDER = "Media";
    static SharedPreferences pref;
    private static Prefs instance;
    private SharedPreferences.Editor editor;

    private Prefs(Context context) {
        pref = context.getSharedPreferences(PREF_NAME, MODE_PRIVATE);
        editor = pref.edit();
    }

    public static Prefs getInstance(Context context) {
        return instance == null ? new Prefs(context) : instance;
    }


    //* Save pref
    public void setValue(String key, Object value) {
        delete(key);
        if (value instanceof Boolean) {
            editor.putBoolean(key, (Boolean) value);
        } else if (value instanceof Integer) {
            editor.putInt(key, (Integer) value);
        } else if (value instanceof Float) {
            editor.putFloat(key, (Float) value);
        } else if (value instanceof Long) {
            editor.putLong(key, (Long) value);
        } else if (value instanceof String) {
            editor.putString(key, (String) value);
        } else if (value instanceof Enum) {
            editor.putString(key, value.toString());
        } else if (value != null) {
            Log.e(TAG, "Attempting to save non-primitive preference");
        }
        editor.commit();
    }

    //*delete specific pref
    private void delete(String key) {
        if (pref.contains(key)) {
            editor.remove(key).commit();
        }
    }

    //*get Pref
    public <T> T getValue(String key, T defValue) {
        T returnValue = (T) pref.getAll().get(key);
        return returnValue == null ? defValue : returnValue;
    }


    // ***************************************** Clear all data from Share Preference *******************************
    public void cleanPref() {
        pref.edit().clear().apply();

    }

    //* User All Data
    public String getUserFirstName() {
        return getValue("username", "");
    }

    public void setUserFirstName(String userName) {
        setValue("username", userName);
    }

    public String getProfileImage() {
        return getValue("ProfileImage", "");
    }

    public void setProfileImage(String ProfileImage) {
        setValue("ProfileImage", ProfileImage);
    }

    public Long getLastSyncTime() {
        return getValue("LastSyncTime", Long.parseLong("1659598797201"));
    }

    public void setLastSyncTime(Long LastSyncTime) {
        setValue("LastSyncTime", LastSyncTime);
    }

    public Long getTodaysUsage() {
        return getValue("TodaysUsage", Long.parseLong("000000"));
    }

    public void setTodaysUsage(Long LastSyncTime) {
        setValue("TodaysUsage", LastSyncTime);
    }

    public String getToken() {
        return getValue("token", Token);
    }

    public void setToken(String LastSyncTime) {
        setValue("token", LastSyncTime);
    }

    public Integer getUserid() {
        return getValue("Userid", 0);
    }

    public void setUserid(Integer Userid) {
        setValue("Userid", Userid);
    }

    public String getMobile() {
        return getValue("Mobile", "");
    }

    public void setMobile(String Mobile) {
        setValue("Mobile", Mobile);
    }

    public String getCountrycode() {
        return getValue("Countrycode", "");
    }

    public void setCountrycode(String Mobile) {
        setValue("Countrycode", Mobile);
    }

    public String getEmail() {
        return getValue("Email", "");
    }

    public void setEmail(String Email) {
        setValue("Email", Email);
    }

    public String getDOB() {
        return getValue("DOB", "");
    }

    public void setDOB(String DOB) {
        setValue("DOB", DOB);
    }

    public String getBalance() {
        return getValue("Balance", "0.0");
    }

    public void setBalance(String Balance) {
        setValue("Balance", Balance);
    }

    public Boolean getIsLogin() {
        return getValue("is_login", false);
    }

    public void setIsLogin(Boolean isLogin) {
        setValue("is_login", isLogin);
    }

}
