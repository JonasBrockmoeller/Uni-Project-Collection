package TrafficLight.Enum;

import TrafficLight.Entities.ColorInterface;

public enum Color implements ColorInterface {
    RED{
        @Override
        public String[] getColor() {
            return new String[]{"#ff0004"};
        }
    },YELLOW{
        @Override
        public String[] getColor() {
            return new String[]{"#ffff00"} ;
        }
    },RED_YELLOW{
        @Override
        public String[] getColor() {
            return new String[] {"#ff0004", "#ffff00"};
        }
    },GREEN{
        @Override
        public String[] getColor() {
            return new String[] {"#00ff00"};
        }
    },OFF{
        @Override
        public String[] getColor() {
            return new String[]{"2b2b2b"};
        }
    };
}
