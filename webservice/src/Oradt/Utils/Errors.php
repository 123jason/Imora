<?php

namespace Oradt\Utils;

/**
 * 错误代码
 */
class Errors
{

    //success
    public static $SUCCESS_OK = 0;
    //failed
    public static $FAILED = 1;
    //common errors
    public static $ERROR_UNKNOWN = array('errorcode' => 999001, 'description' => 'error unknown');
    public static $ERROR_PARAMETER_FORMAT = array('errorcode' => 999002, 'description' => 'invalid parameter format');
    public static $ERROR_PARAMETER_NOT_ENOUGH = array('errorcode' => 999003, 'description' => 'parameter not enough');
    public static $ERROR_PARAMETER_NOT_DATA = array('errorcode' => 999004, 'description' => 'error no data');
    public static $ERROR_PARAMETER_DATA_EXISTS = array('errorcode' => 999005, 'description' => 'data exists');
    public static $ERROR_PARAMETER_FILE_NOT_EXISTS = array('errorcode' => 999006, 'description' => 'file does not exist');
    public static $ERROR_PARAMETER_UNI_NAME = array('errorcode' => 999007, 'description' => 'error name duplicate');
    public static $ERROR_PARAMETER_NOT_UPDATE = array('errorcode' => 999008, 'description' => 'error not need modify');//del
    public static $ERROR_PARAMETER_LINK_EXPIRED = array('errorcode' => 999009, 'description' => 'link has expired');
    public static $ERROR_PARAMETER_CODE_EXPIRED = array('errorcode' => 999010, 'description' => 'code has expired');
    public static $ERROR_PARAMETER_VERIFY_CODE = array('errorcode' => 999011, 'description' => 'verification code error');
    public static $ERROR_INVALID_ACCESS = array('errorcode' => 999012, 'description' => 'invalid access');
    public static $ERROR_NOT_ALLOWED_LOGIN = array('errorcode' => 999013, 'description' => 'account have login');
    public static $ERROR_PARAMETER_STATE_ENOUGH = array('errorcode' => 999014, 'description' => 'parameter state error');
    public static $ERROR_PARAMETER_BIZ_ENOUGH = array('errorcode' => 999015, 'description' => 'bizid not enough');
    public static $ERROR_EMAIL_FORMAT = array('errorcode' => 999016, 'description' => 'error email format');
    public static $ERROR_MOBILE_FORMAT = array('errorcode' => 999017, 'description' => 'error mobile format');
    public static $ERROR_ORDER_FIELDS_FORMAT = array('errorcode' => 999018, 'description' => 'error order field format');
    public static $ERROR_QUERY_EXCEPTION = array('errorcode' => 999019, 'description' => 'query sql exception');
    public static $ERROR_ACCOUNT_NOEXISTS = array('errorcode' => 999020, 'description' => 'account not exists');
    public static $ERROR_PARAMTER_ERROR = array('errorcode' => 999021, 'description' => '%s error');
    public static $ERROR_SUB_EXISTS = array('errorcode' => 999022, 'description' => '%s is exists');
    public static $MOBILE_DUPLICATE = array('errorcode' => 999023, 'description' => 'mobile duplicate');
    public static $EMAIL_DUPLICATE = array('errorcode' => 999024, 'description' => 'email duplicate');
    public static $ERROR_NOT_HAVE_PERMISSION = array('errorcode' => 999025, 'description' => 'you do not have permission'); //你没有权限
    public static $ERROR_PARAMETER_FORMAT_DYNAMIC = array('errorcode' => 999026, 'description' => 'invalid parameter format:%s');
    public static $ERROR_IMID_NOTEXISTS = array('errorcode' => 999027, 'description' => 'imid not exists');
    public static $ERROR_LENGTH_LIMIT = array('errorcode' => 999028, 'description' => '%s length exceeds the limit');
    public static $ERROR_NOTEXISTS = array('errorcode' => 999029, 'description' => '%s not exists');
    public static $ERROR_SEND_MESSAGE_FAILE = array('errorcode' => 999030, 'description' => 'send message faile');
    public static $ERROR_HAS_BEEN_PROCESSED = array('errorcode' => 999031, 'description' => 'has been processed');
    public static $ERROR_MESSAGE_HAS_BEEN_EXPIRED = array('errorcode' => 999032, 'description' => 'message has been expired');
    public static $ERROR_BINDING_STATUS = array('errorcode' => 999033, 'description' => 'have a binding');
    public static $ERROR_CUSTOMER_LOCK = array('errorcode' => 999034, 'description' => 'confirm the customer regtype');
    public static $ERROR_IP_BLACKLIST = array('errorcode' => 999035, 'description' => 'ip blacklist');
    public static $ERROR_DATA_DUPLICATE = array('errorcode' => 999036, 'description' => '%s duplicate');
    public static $ERROR_DATA_NEWSET = array('errorcode' => 999037, 'description' => 'the data is new');
    public static $ERROR_DATA_OUT_OF_BOUNDS = array('errorcode' => 999038, 'description' => 'the data is out of bounds');
    public static $ERROR_DATA_NULL = array('errorcode' => 999039, 'description' => 'data is null');
    
    //oauth errors
    public static $OAUTH_ERROR_UNKNOWN = array('errorcode' => 100001, 'description' => 'error unknown');
    public static $OAUTH_ERROR_INVALID_USER = array('errorcode' => 100002, 'description' => 'invalid user');
    public static $OAUTH_ERROR_PASSWORD = array('errorcode' => 100003, 'description' => 'password not correct');
    public static $OAUTH_ERROR_EMAIL = array('errorcode' => 100004, 'description' => 'email not correct');
    public static $OAUTH_ERROR_MOBILE = array('errorcode' => 100005, 'description' => 'mobile not correct');
    public static $OAUTH_ERROR_EXPIRATION = array('errorcode' => 100006, 'description' => 'expirated session');
    public static $OAUTH_ERROR_MISS_ACCESSTOKEN = array('errorcode' => 100007, 'description' => 'miss access token');
    public static $OAUTH_ERROR_EXISTS_USER = array('errorcode' => 100008, 'description' => 'user exists');
    public static $OAUTH_ERROR_USER_NAME = array('errorcode' => 100009, 'description' => 'user name error');
    public static $OAUTH_ERROR_USER_PWD = array('errorcode' => 100010, 'description' => 'user pwd error');
    public static $OAUTH_ERROR_ACCOUNT_ABNORMAL = array('errorcode' => 100011, 'description' => 'account abnormal'); //账户异常
    public static $OAUTH_ERROR_ACCOUNT_LOCKOUT = array('errorcode' => 100012, 'description' => 'account is locked'); //账户锁定
    public static $OAUTH_ERROR_ACCOUNT_TEN_MINS = array('errorcode' => 100013, 'description' => 'locked not more than 10 minutes'); //账户锁定没超过10分钟 
    public static $OAUTH_ERROR_ORANGE_DEVICE_MISSING = array('errorcode' => 100014, 'description' => 'orange device missing'); //橙子设备丢失
    public static $OAUTH_ERROR_ORANGE_DEVICE_CLEAR_DATA = array('errorcode' => 100015, 'description' => 'orange device need to clear data'); //橙子设备清除数据
    public static $OAUTH_ERROR_ORANGE_DEVICE_LOST_BING = array('errorcode' => 100016, 'description' => 'orange device has lost bing'); //
    public static $OAUTH_ERROR_NOTEXISTS_USER = array('errorcode' => 100017, 'description' => 'user not exists');
    public static $WECHAT_ERROR_INVALID_USER = array('errorcode' => 100018, 'description' => 'invalid wechat user');
    //account biz
    public static $ACCOUNT_BIZ_ERROR_UNKNOWN = array('errorcode' => 200001, 'description' => 'error unknown');//del
    public static $ACCOUNT_BIZ_ERROR_DUPLICATE = array('errorcode' => 200002, 'description' => 'error duplicate');//del
    public static $ACCOUNT_BIZ_ERROR_EMAIL = array('errorcode' => 200003, 'description' => 'error email format');//del
    public static $ACCOUNT_BIZ_ERROR_PWD = array('errorcode' => 200004, 'description' => 'error passwd format');//del
    public static $ACCOUNT_BIZ_ERROR_UNI_USER = array('errorcode' => 200005, 'description' => 'error user duplicate');//del
    public static $ACCOUNT_BIZ_ERROR_UNI_BIZNAME = array('errorcode' => 200006, 'description' => 'error bizname duplicate');//del
    public static $ACCOUNT_BIZ_ERROR_UNI_USERNAME = array('errorcode' => 200007, 'description' => 'user or password parameter format');//del
    public static $ACCOUNT_BIZ_ERROR_TEMP_EXISTS = array('errorcode' => 200008, 'description' => 'template not exist');//del
    public static $ACCOUNT_BIZ_ERROR_GROUP_EXISTS = array('errorcode' => 200009, 'description' => 'group not exist');
    public static $ACCOUNT_BIZ_ERROR_OLD_PASSWORD = array('errorcode' => 200010, 'description' => 'old password not correct');//del
    public static $ACCOUNT_BIZ_OPERATOR_EXISTS = array('errorcode' => 200011, 'description' => 'bizoperator exists');
    public static $ACCOUNT_BIZ_ALREADLY_FOLLOW = array('errorcode' => 200012, 'description' => 'the biz alreadly follow');//del
    public static $ACCOUNT_BIZ_USER_LIMITED = array('errorcode' => 200013, 'description' => 'the biz user limited ');//del
    public static $ACCOUNT_BIZ_USER_INACTIVE = array('errorcode' => 200014, 'description' => 'the biz user inactive ');//del
    public static $ACCOUNT_BIZ_USER_DELETED = array('errorcode' => 200015, 'description' => 'the biz user deleted ');//del
    public static $ACCOUNT_BIZ_BOUND_MOBILE = array('errorcode' => 200016, 'description' => 'the mobile has been bound ');//del
    public static $ACCOUNT_BIZ_BOUND_EMAIL = array('errorcode' => 200017, 'description' => 'the email has been bound ');
    public static $ACCOUNT_BIZ_CONNOT_DELETE = array('errorcode' => 200018, 'description' => 'the role has employees,could not delete ');
    public static $ACCOUNT_BIZ_GCONNOT_DELETE = array('errorcode' => 200019, 'description' => 'the group has employees,could not delete ');
    public static $ACCOUNT_BIZ_EMP_LOGIN = array('errorcode' => 200020, 'description' => 'the employee regist error');
    public static $ACCOUNT_BIZ_EMP_NOTSELF = array('errorcode' => 200021, 'description' => ' biz permission denied ');
    public static $ACCOUNT_BIZ_CONNOT_IDENT = array('errorcode' => 200022, 'description' => ' biz can not ident ');
    public static $ACCOUNT_BIZ_EMP_ENABLE = array('errorcode' => 200023, 'description' => ' employee can not use biz  ');
    public static $ACCOUNT_EMPLOYEE_CONNOT_IDENT = array('errorcode' => 200024, 'description' => ' employee can not ident ');
    public static $ACCOUNT_BIZ_NOT_EXISTS_EMPLOYEE = array('errorcode' => 200025, 'description' => ' Enterprises have no employees ');
    public static $ACCOUNT_BIZ_TERM_NOT_EXISTS = array('errorcode' => 200026, 'description' => ' Enterprise packages do not exist ');
    public static $ACCOUNT_BIZ_TERM_EXISTS = array('errorcode' => 200027, 'description' => ' Enterprise packages already exist ');
    public static $ACCOUNT_TERM_NOT_EXISTS = array('errorcode' => 200028, 'description' => ' The package data does not exist ');
    public static $ACCOUNT_TERM_OFF  = array('errorcode' => 200029, 'description' => ' The package is off the shelf ');

    //account baisc
    public static $ACCOUNT_BASIC_ERROR_UNKNOWN = array('errorcode' => 300001, 'description' => 'error unknown');//noice
    public static $ACCOUNT_BASIC_ERROR_DUPLICATE = array('errorcode' => 300002, 'description' => 'mobile duplicate');
    public static $ACCOUNT_BASIC_ERROR_PASSWORD = array('errorcode' => 300003, 'description' => 'password not correct');
    public static $ACCOUNT_BASIC_SECURITY_VERIFY = array('errorcode' => 300004, 'description' => 'verify failure');
    public static $ACCOUNT_BASIC_BIZCARD_NOT_EXISTS = array('errorcode' => 300005, 'description' => 'bizcard not exists');
    public static $ACCOUNT_BASIC_GENDER_NOT_FORMAT = array('errorcode' => 300006, 'description' => 'gender not in m,f');
    public static $ACCOUNT_BASIC_BIRTHDAY_NOT_FORMAT = array('errorcode' => 300007, 'description' => 'birthday format error');
    public static $ACCOUNT_BASIC_OLD_PASSWD = array('errorcode' => 300008, 'description' => 'old passwd error');
    public static $ACCOUNT_SECURITY_ANSWER = array('errorcode' => 300009, 'description' => 'answer error');
    public static $ACCOUNT_BASIC_CONFIG_BACKGROUND = array('errorcode' => 300010, 'description' => 'the background alreadly created');
    public static $ACCOUNT_BASIC_EMAIL_DUPLICATE = array('errorcode' => 300011, 'description' => 'email duplicate');
    public static $ACCOUNT_FRIEND_CLIENTID_ERROR = array('errorcode' => 300012, 'description' => 'clientid error');
    public static $ACCOUNT_BASIC_lETTER_IS_VALID = array('errorcode' => 300013, 'description' => 'recommendation letter is not valid');
    public static $ACCOUNT_BASIC_ALREADLY_FRIENDS = array('errorcode' => 300014, 'description' => 'already friends');
    //account admin
    public static $ACCOUNT_ADMIN_ERROR_ROLE_NOTEXISTS = array('errorcode' => 310001, 'description' => 'roleid not exists');
    public static $ACCOUNT_ADMIN_ERROR_EXISTS = array('errorcode' => 310002, 'description' => 'email have exists');
    public static $ACCOUNT_ADMIN_SCANNER_EXISTS = array('errorcode' => 310003, 'description' => 'scannerid have exists');
    public static $WX_BIZ_ERROR_ROLE_LAST = array('errorcode' => 310004, 'description' => 'roleid only last one');

    //account order
    public static $ORDER_STATUS_ERROR   = array('errorcode' => 330001, 'description' => 'order status error');
    public static $ORDER_NOT_EXISTS     = array('errorcode' => 330002, 'description' => 'order not exists');
    public static $ORDER_PAYMENT_ERROR  = array('errorcode' => 330003, 'description' => 'order payment error');
    public static $ORDER_PRICE_ERROR    = array('errorcode' => 330004, 'description' => 'order price is null');
    public static $ORDER_REFUND_ERROR   = array('errorcode' => 330005, 'description' => 'order refund error');
    public static $ORDER_RECHARGE_RULES_TYPE_ERROR   = array('errorcode' => 330006, 'description' => 'recharge rules type error');
    public static $ORDER_RECHARGE_RULES_NOT_EXISTS   = array('errorcode' => 330007, 'description' => 'recharge rules not exists');
    public static $ORDER_HAS_BEEN_EXPIRED       = array('errorcode' => 330008, 'description' => 'order has been expired');
    public static $ORDER_HAS_ALREADY_COMMENT    = array('errorcode' => 330009, 'description' => 'order already comment');
    public static $BIZORDER_AUTHORID_NOT_EXISTS = array('errorcode' => 330010, 'description' => 'authorid not exists');
    
    //orange
    public static $ORANGE_CARD_TYPE_NOT_EXISTS  = array('errorcode' => 360001, 'description' => 'cardtype not exists');  //卡类型不存在
    public static $ORANGE_TAG_TYPE_NOT_EXISTS   = array('errorcode' => 360002, 'description' => 'tag type not exists');   //标签类型不存在
    public static $ORANGE_TAG_TYPE_CANNOT_DEL   = array('errorcode' => 360003, 'description' => 'The tag type cannot be deleted');   //标签不能被删除
    public static $ORANGE_CARD_LSSUER_NAME_EXISTS   = array('errorcode' => 360004, 'description' => 'lssuername exists under this cardtypeid');  //发卡单位在这个卡类型下已存在
    public static $ORANGE_CARD_LSSUER_NUMBER_EXISTS = array('errorcode' => 360005, 'description' => 'lssuernumber exists under this cardtypeid');  //发卡单位编码在这个卡类型下已存在
    public static $ORANGE_CARD_LSSUER_CANNOT_DEL = array('errorcode' => 360006, 'description' => 'The card lssuer cannot be deleted');  //发卡单位在在卡类型模板中被使用不能删除
    public static $ORANGE_CARD_LSSUER_SIMPLENAME_EXISTS = array('errorcode' => 360007, 'description' => 'simplename exists under this cardtypeid');  //发卡单位简称在这个卡类型下已存在
    
    //passwd reset
    public static $ACCOUNT_PASSWD_RESET = array('errorcode' => 400001, 'description' => 'password reset failed');
    public static $ACCOUNT_PASSWD_RESET_UUID_USE = array('errorcode' => 400002, 'description' => 'uuid have is use');
    public static $ACCOUNT_PASSWD_RESET_UUID_EXPIRE = array('errorcode' => 400003, 'description' => 'uuid have is expire');
    public static $ACCOUNT_PASSWD_RESET_UUID_IP = array('errorcode' => 400004, 'description' => 'invalid ip');
    public static $ACCOUNT_PASSWD_RESET_CODE_INVALID = array('errorcode' => 400005, 'description' => 'code is invalid or expired');
    //guild
    public static $GUILD_MEMBER_ERROR_GUILD_NOT_EXISTS = array('errorcode' => 500001, 'description' => 'guild not exist');
    public static $GUILD_MEMBER_ERROR_MEMBER_EXISTS = array('errorcode' => 500002, 'description' => 'member exist');
    public static $GUILD_MEMBER_ERROR_MEMBERID      = array('errorcode' => 500003, 'description' => 'error memberid');
    //topic
    public static $TOPIC_ERROR_CATEGORY_EXISTS = array('errorcode' => 600001, 'description' => 'category exist');
	public static $TOPIC_FLAG_ERROR = array('errorcode' => 600002, 'description' => 'flag format error');
    //contact
    public static $CONTACT_ERROR_DEFAULT_GROUP = array('errorcode' => 700001, 'description' => 'default group cannot be modified');
    public static $CONTACT_ERROR_GROUP_SORT = array('errorcode' => 700002, 'description' => 'sorting value error cannot be <10');
    public static $CONTACT_ERROR_NOT_EXISTS = array('errorcode' => 700003, 'description' => 'contact not exist');
    public static $CONTACT_CARD_ERROR_NOT_EXISTS = array('errorcode' => 700004, 'description' => 'contact card not exist');//del
    public static $CONTACT_ERROR_HAS_USED = array('errorcode' => 700005, 'description' => '%s has used');
    public static $CONTACT_ERROR_GROUPID_NOTEXIST = array('errorcode' => 700006, 'description' => 'groupid not exist');
    public static $CONTACT_ERROR_CONTACTID = array('errorcode' => 700007, 'description' => 'contactid error');//del
    public static $CONTACT_ERROR_VCF_FORMAT = array('errorcode' => 700008, 'description' => 'vcf format error');
    public static $CONTACT_ERROR_NINDEX_CARD_NOT_EXISTS = array('errorcode' => 700009, 'description' => 'nindex card not exist');  //首页名片不存在
    public static $CONTACT_ERROR_PUBLIC_STATUS = array('errorcode' => 700010, 'description' => 'card prohibit sharing');  //名片禁止共享
    public static $CONTACT_ERROR_NOT_ALLOWED_BUY = array('errorcode' => 700011, 'description' => 'cards are not allowed to buy');  //名片不允许购买
    public static $CONTACT_ERROR_AlREADY_EXIST = array('errorcode' => 700012, 'description' => 'card are already exist');  //名片已经存在名片夹下
    public static $CONTACT_ERROR_SELF_CARD_EXISTS = array('errorcode' => 7000013, 'description' => 'self card exist');//身份名片超出限制
    //relation
    //sns相关
    public static $SNS_ACCOUNT_ERROR_NOT_EXISTS      = array('errorcode' => 710001, 'description' => 'sns account not exists');   
   
    public static $SNS_ACTIVITY_ERROR_ALREADY_FOLLOW = array('errorcode' => 710005, 'description' => 'the activity already follow');
    public static $SNS_ACTIVITY_RESOURCE_ERROR_NOT_EXISTS = array('errorcode' => 710006, 'description' => 'the activity resource not exists');
    public static $SNS_ACTIVITY_RESOURCE_NOT_PERMISSION   = array('errorcode' => 710007, 'description' => 'You do not have permission to perform this operation');
    public static $SNS_GROUP_ERROR_NOT_EXISTS   = array('errorcode' => 710008, 'description' => 'the group not exists');
    public static $SNS_GROUP_ERROR_JOIN_HAVEIN  = array('errorcode' => 710009, 'description' => 'You have been in the group');
    public static $SNS_ACCOUNT_NOT_IN_GROUP     = array('errorcode' => 710010, 'description' => 'You not in the group');
    public static $CLIENT_DUPLICATE = array('errorcode' => 710020, 'description' => 'clientid duplicate');
	public static $SNS_NO_MAXIM_COMMENT     = array('errorcode' => 710030, 'description' => 'You have no this comment');

    //hr相关
    public static $HR_BIZDEP_NOT_EXISTS = array('errorcode' => 720001, 'description' => 'biz department not exist');
    public static $HR_RECRUITER_NOT_EXISTS = array('errorcode' => 720002, 'description' => 'hr recruiter not exist');
    public static $HR_HRCANDIDATE_NOT_EXISTS=array('errorcode' =>720003, 'description' => 'hr hrcandidate not exists');  //wangll   hr候选人
    public static $HR_CANDIDATE_PARAMETER_ERROR=array('errorcode' =>720004, 'description' => 'hr candidate  type error');

    public static $HR_JOB_NOT_EXIST_ERROR=array('errorcode' =>720005, 'description' => 'jobid not exist');
    public static $HR_JOB_APPLY_NOT_EXIST_ERROR=array('errorcode' =>720006, 'description' => 'job applyid not exist');//del
    public static $ERROR_PARAMETER_RETACT= array('errorcode' => 720007, 'description' => 'parameter retact error');//del
    public static $ERROR_PARAMETER_NOT_EXIST_ERROR= array('errorcode' => 720008, 'description' => 'parameter biz not exist');
    public static $ERROR_HR_CANDIDATE_DUPLICATE = array('errorcode' => 720008, 'description' => 'hr candidateid duplicate error');//del

    public static $ERROR_HR_JOB_DUPLICATE = array('errorcode' => 720009, 'description' => 'hr jobid duplicate error');
    public static $ERROR_HR_OBJECTIVE_NOT_EXIST_ERROR = array('errorcode' => 720010, 'description' => 'hr objectiveid not exist error');
    public static $ERROR_HR_EDUCATION_NOT_EXIST_ERROR = array('errorcode' => 720011, 'description' => 'hr education not exist error');
    public static $ERROR_HR_EXPERIENCE_NOT_EXIST_ERROR = array('errorcode' => 720012, 'description' => 'hr experience not exist error');

    public static $ERROR_HR_DATA_NOT_EXIST_ERROR = array('errorcode' => 720013, 'description' => 'data not exist error');
    public static $ERROR_HR_DATA_SALARY_ERROR = array('errorcode' => 720014, 'description' => 'parameter yearsalary format error');//del
    public static $ERROR_HR_DATA_EXPERIENCE_ERROR = array('errorcode' => 720015, 'description' => 'parameter experience format error');//del
    public static $ERROR_HR_DATA_FORMAT_ERROR = array('errorcode' => 720016, 'description' => 'parameter format error');//del


    //yps 
    public static $YPS_CATETORYID_NOT_EXISTS = array('errorcode' => 730001, 'description' => 'categoryid not exist');
    public static $YPS_STATUS_ERROR = array('errorcode' => 730010, 'description' => 'status error');
    /**
     * 
     * @var 两张名片属于同一个账号
     */
    public static $RELATION_ERROR_USERID_DUPLICATE = array('errorcode' => 800001, 'description' => 'vcard userId duplicate');
    public static $RELATION_ERROR_STATE_DISABLE = array('errorcode' => 800002, 'description' => 'introducation state disable');
    /**
     * @var 不是自定义名片
     */
    public static $RELATION_ERROR_VCARD_NOSELF = array('errorcode' => 800003, 'description' => 'is not a custom business cards');

    public static $RELATION_ERROR_VCARD_SHARED = array('errorcode' => 800004, 'description' => 'business cards have been shared');
    
    
    //message
    public static $MESSAGE_ERROR_UID = array('errorcode' => 810001, 'description' => 'Uid not exist');
    //document
    public static $DOCUMENT_ERROR_NAME_DUPLICATE = array('errorcode' => 820001, 'description' => 'directory name duplicate');
    public static $DOCUMENT_DELETE_DIRECTORY_NO_EMPTY = array('errorcode' => 820002, 'description' => 'directory no empty');
    
    public static $HTTP_STATUS_CODE_500 = array('errorcode' => 500, 'description' => 'Internal server error');
    public static $HTTP_STATUS_CODE_405 = array('errorcode' => 405, 'description' => 'Request method not allowed');
    public static $HTTP_STATUS_CODE_404 = array('errorcode' => 404, 'description' => 'page not found');
    public static $HTTP_STATUS_CODE_403 = array('errorcode' => 403, 'description' => 'Insufficient permissions');
    //展会错误信息
    public static $EXPO_ERROR_USERID_DUPLICATE = array('errorcode' => 900000, 'description' => 'expo userId duplicate');//del
    public static $EXPO_ERROR_USERID_DELETE = array('errorcode' => 900001, 'description' => 'no value to delete');//del
    public static $EXPO_ERROR_TICKET_DUPLICATE = array('errorcode' => 900002, 'description' => 'expo ticket duplicate');
    public static $EXPO_ERROR_EXPO_OFF = array('errorcode' => 900003, 'description' => 'expo is off');
    public static $EXPO_ERROR_TICKET_RECEIVE = array('errorcode' => 900004, 'description' => 'ticket no receive');
    public static $EXPO_ERROR_ALREADY_SIGN = array('errorcode' => 900005, 'description' => 'ticket Already sign');
    //设计师相关
    public static $DESIGN_ERROR_MONEY_NOT_ENOUGH = array('errorcode' => 110001, 'description' => 'money not enough');
    public static $DESIGN_ERROR_TRADE_STATUS_ERROR = array('errorcode' => 110002, 'description' => 'status error');
    public static $DESIGN_ERROR_NO_FUND_BALANCE = array('errorcode' => 110003, 'description' => 'no fund account');
    public static $DESIGN_ERROR_ORDER_STATE_ERROR = array('errorcode' => 110004, 'description' => 'order state error');
    public static $DESIGN_ERROR_BIDDING_INFO = array('errorcode' => 110005, 'description' => 'Have bidding info');
    public static $DESIGN_ERROR_BIDDING_TIME_OUT = array('errorcode' => 110006, 'description' => 'project deadlline time out');
    public static $DESIGN_ERROR_PROJECT_STATUS = array('errorcode' => 110007, 'description' => 'project status error');
    public static $DESIGN_ERROR_PROJECT_DATE = array('errorcode' => 110008, 'description' => 'project date type error');
    public static $DESIGN_ERROR_PARAMETER = array('errorcode' => 110009, 'description' => 'parameter %s value error');
    public static $DESIGN_ERROR_NICKNAME = array('errorcode' => 110010, 'description' => 'nickname exists');
    public static $DESIGN_ERROR_MOBILE = array('errorcode' => 110011, 'description' => 'mobile exists');
    public static $DESIGN_ERROR_EMAIL = array('errorcode' => 110012, 'description' => 'email exists');
    public static $DESIGN_ERROR_PRODUCT_ERROR = array('errorcode' => 110013, 'description' => 'product invalid');
    public static $DESIGN_ERROR_WEIXIN_UNIT = array('errorcode' => 110014, 'description' => 'wechat pay only CNY');
    public static $DESIGN_ERROR_NO_DATA = array('errorcode' => 110015, 'description' => 'error no %s data');
    public static $DESIGN_ERROR_TRADE_TOUID = array('errorcode' => 110016, 'description' => 'trades to userid err');
    public static $DESIGN_ERROR_INTERNAL = array('errorcode' => 110017, 'description' => '%s err');
    public static $DESIGN_ERROR_PAYPAL_ID = array('errorcode' => 110018, 'description' => 'PAY_ID is used');
    public static $DESIGN_ERROR_PAYPAL_UNIT = array('errorcode' => 110019, 'description' => 'paypal only CNY');
    public static $DESIGN_ERROR_BIDDING_STATUS = array('errorcode' => 110020, 'description' => 'bidding status error');
    public static $DESIGN_ERROR_CURL_ERROR = array('errorcode' => 110021, 'description' => 'iap curl error: %s');
    public static $DESIGN_ERROR_IAP_ERROR = array('errorcode' => 110022, 'description' => 'iap verify %s');
   //名片录入相关
    public static $CARD_ERROR_DETAL_CARD_EXIST = array('errorcode' => 10000, 'description' => 'this card  detal time log exists');
    public static $CARD_ERROR_DETAL_CARD_NOT_EXIST = array('errorcode' => 10001, 'description' => 'this card  detal time log not exists');
    //mark点流程相关
    public static $CARD_ERROR_MARK_HANDLE_INFO_EXIST = array('errorcode' => 20000, 'description' => 'this card  mark handle info  exists');
    public static $CARD_ERROR_MARK_HANDLE_INFO_NOT_EXIST = array('errorcode' => 20001, 'description' => 'this card mark handle info  not exists');
    public static $CARD_ERROR_MARK_HANDLE_INFO_DONOT_OWN_CARD = array('errorcode' => 20002, 'description' => 'this card is not belong to you');
    public static $CARD_ERROR_DISPATCH_NUM_NOT_ENOUGH = array('errorcode' => 30000, 'description' => 'the card need to dispatch is not enough');

}

