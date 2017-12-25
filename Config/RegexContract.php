<?php 


//final class RegexContract {

    final class RegexContract {
        const CONTROLLER_METHOD_PARSER = "/^((\w+)\/(\w+))/";
        const QUERY_PARSER = "/{\w+\?*}/";
        const OPTIONAL_QUERY_PARAMETERS = "/\w+\?/";
    }
//}
?> 