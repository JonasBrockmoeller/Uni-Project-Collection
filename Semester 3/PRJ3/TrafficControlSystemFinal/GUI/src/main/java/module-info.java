module com.example.gui {
    requires BusinessLogic;
    requires javafx.graphics;
    requires javafx.fxml;
    requires javafx.controls;
    opens com.example.gui to javafx.fxml;
    exports com.example.gui;
}