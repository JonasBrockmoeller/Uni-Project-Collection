/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.mycompany.adapter_pattern;

/**
 *
 * @author jonasbrockmoller
 */
public class Mallard implements Duck {

    @Override
    public void quack() {
        System.out.println("Mallard quacks");
    }

    @Override
    public void fly() {
        System.out.println("Mallard flies");
    }

}
