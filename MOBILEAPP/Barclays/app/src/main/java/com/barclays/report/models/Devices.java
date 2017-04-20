package com.barclays.report.models;

/**
 * Created by francis on 18/03/2016.
 */
public class Devices {
    public long id;
    public String name;

    public Devices(long id, String name) {
        this.id = id;
        this.name = name;
    }

    @Override
    public String toString() {
        return this.name;
    }


    public Devices() {
    }

    public long getId() {
        return id;
    }

    public void setId(long id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }
}
