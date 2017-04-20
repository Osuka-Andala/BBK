package com.barclays.report.models;

/**
 * Created by francis on 18/03/2016.
 */
public class County {
    public int id;
    public String name;

    public County(int id, String name) {
        this.id = id;
        this.name = name;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }
}
