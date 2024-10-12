import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
// import { faDiceD20, faUser } from '@fortawesome/free-solid-svg-icons'
import { fas } from "@fortawesome/free-solid-svg-icons";
import { far } from "@fortawesome/free-regular-svg-icons";
import { faSun, faMoon } from "@fortawesome/free-regular-svg-icons";

// library.add(faDiceD20)
// library.add(faUser)
library.add(fas);
library.add(far);
library.add([faSun, faMoon]);

export default FontAwesomeIcon;
