<?php

/*
 * This file is part of the Utils package.
 *
 * (c) Symfony 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oradt\Utils;

/**
 * List of status response status codes.
 *
 * The list of codes is complete according to the
 * Unless otherwise noted, the status code is defined in RFC01.
 *
 * @author Xie Zhiqiang <xiezq@oradt.com>
 * @author Chen xuming <chenxm@oradt.com>
 */
final class Codes
{
    /**
     * 个人ID分配
     */

    const A = 'A';
    /**
     * 企业ID分配
     */
    const B = 'B';
    /**
     * 管理员ID分配
     */
    const C = 'C';
    /**
     * 企业
     */
    const BIZ = 'biz';
    /**
     * 个人
     */
    const BASIC = 'basic';
    /**
     * 个人文件
     */
    const FILE = 'file';
    /**
     * 管理员文件
     */
    const SYS = 'sys';
    /**
     * 背景配置
     */
    const BACKGROUND = 'background';
    /**
     * 分页长度
     */
    const LIMIT = 10;
    /**
     * 鉴权token长度
     */
    const TOKEN_LENGTH = 40;
    /**
     * token有效时间(秒)
     */
    const TOKEN_EXPIRE_TIME = 100003600;
    /**
     * 验证有效时间(秒) 24小时 邮件时用 不要随意改动
     */
    const VERIFY_EXPIRE_TIME = 86400;
    /**
     * 登录注册 验证短信有效时间(秒) 为5分钟  不要随意改动 
     */
    const VERIFY_SMS_EXPIRE_TIME = 300;
    
    /**
     * 重置密码 验证短信有效时间(秒) 为3分钟  不要随意改动 
     */
    const PASSWDRESET_VERIFY_SMS_EXPIRE_TIME = 180;
    
    /**
     * 验证时长（秒）
     * 使用场景：短信在10S内 只能发送一次 在10S内 返回最后一条数据
     */
    const VERIFY_LENGTH_TIME = 10;
    /**
     * 缓存有效时间(秒)
     */
    const CACHE_EXPIRE_TIME = 3600;
    /**
     * 时间格式化
     */
    const SIMPLE_DATE = "Y-m-d H:i:s";
    /**
     * 
     * @var 系统头像前辍
     */
    const SYSTEM_AVATAR_PRE = 'sysdocument/avatar/';
    /**
     * 同步方向，向下
     */
    const DOWN = 'down';
    /**
     * 同步方向，向上
     */
    const UP = 'up';
    /**
     * 同步状态
     */
    const SYNC_ADD = 'add';
    const SYNC_MODIFY = 'modify';
    const SYNC_DELETE = 'delete';
    /**
     * sns group member 角色
     */
    const SNS_GROUP_ROLE_ADM  = 'adm';   //群管理
    const SNS_GROUP_ROLE_MEM  = 'mem';   //群成员
    /**
     * @var 默认《未分组》
     */
    const DEFAULT_GROUP = 'Ungrouped';
    /**
     * @var 默认名片分组名《未分组》
     */
    const CONTACT_CARD_DEFAULT_GROUP = 'Ungrouped';
    const CONTACT_CARD_DEFAULT_ORDER = 1;
    /**
     * @var 名片分组 VIP分组名字《VIP》
     */
    const CONTACT_CARD_DEFAULT_GROUP_VIP = 'VIP';
    const CONTACT_CARD_DEFAULT_VIP_ORDER = 0;
    /**
     * @var 我的名片
     */
    const CONTACT_CARD_GROUP_MYCARDS = 'Private Cards';
    const CONTACT_CARD_GROUP_MYCARDS_ORDER = 2;
    /**
     * @var 默认联系人分组《未分组》
     */
    const CONTACT_DEFAULT_GROUP = 'Ungrouped';
    const CONTACT_DEFAULT_ORDER = 0;
    /**
     * @var 发送短信类型
     */
    const SMS_TYPE_TEXT     = 'text';
    const SMS_TYPE_VERIFY   = 'verify';
    
    /**
     * @var 亿美软通 3个账户 分别使用哪个账户
     */
    const USE_YMSMS_VERIFY_ACCOUNT     = "verify";         //验证码账户
    const USE_YMSMS_INFO_ACCOUNT       = "info";           //短消息，信息类账户
    const USE_YMSMS_MARKETING_ACCOUNT  = "marketing";      //营销类账户（推广）
    /**
     * @var 默认联系人分组《未分组》
     */
    //const SMS_VERIFICATION_CODE = '【橙鑫科技】你好，申请的验证码为：%s';
    //const SMS_VERIFICATION_CODE = '【橙鑫科技】验证码：%s，为了保护您的账号安全，验证短信请勿转发给其他人。';
    const SMS_VERIFICATION_CODE = '【橙脉APP】验证码：%s，请尽快完成登录。如非本人操作，请忽略。';
    
    /**
     * @var 默认重置密码验证短信内容
     */
    const SMS_RESETPASSWD_CODE   = '【橙脉APP】密码重置验证码：%s，请尽快完成重置。如非本人操作，请忽略。';

    /**
     * @var 推广短信内容
     */
    const SMS_POPULAR_CODE   = '拓展人脉商务神器，很时尚，一定要分享给您：http://download_Pcard.oradt.com';

    /**
     * 实体映射数据库表名字 ACCOUNT_BASIC
     */
    const ACCOUNT_BASIC   = 'AccountBasic';
    /**
     * 实体映射数据库表名字 ACCOUNT_BASIC_DETAIL
     */
    const ACCOUNT_BASIC_DETAIL   = 'AccountBasicDetail';
    /**
     * 实体映射数据库表名字 AccountBasicLoginRecord
     */
    const ACCOUNT_BASIC_LOGIN_RECORD = 'AccountBasicLoginRecord';
    /**
     * 实体映射数据库表名字 AccountEmplyeeLoginRecord
     */
    const ACCOUNT_EMPLYEE_LOGIN_RECORD = 'AccountEmplyeeLoginRecord';
    /**
     * 实体映射数据库表名字 ACCOUNT_FRIEND
     */
    const ACCOUNT_FRIEND   = 'AccountFriend';
    /**
     * 实体映射数据库表名字 Contact
     */
    const CONTACT = 'Contact';
    /**
     * 实体映射数据库表名字 AccountBiz
     */
    const ACCOUNT_BIZ = 'AccountBiz';
    /**
     * 实体映射数据库表名字 AccountBizDetail
     */
    const ACCOUNT_BIZ_DETAIL = 'AccountBizDetail';
    /**
     * 实体映射数据库表名字 AccountBizExtendInfo
     */
    const ACCOUNT_BIZ_EXTEND_INFO = 'AccountBizExtendInfo';
    /**
     * 实体映射数据库表名字 AccountBizLoginRecord
     */
    const ACCOUNT_BIZ_LOGIN_RECORD = 'AccountBizLoginRecord';
    /**
     * 实体映射数据库表名字 BizCard
     */
    const BIZ_CARD = 'BizCard';
    /**
     * 实体映射数据库表名字 BizCardApplyInfo
     */
    const BIZ_CARD_APPLY_INFO = 'BizCardApplyInfo';
    /**
     * 实体映射数据库表名字 BizCardGroup
     */
    const BIZ_CARD_GROUP = 'BizCardGroup';
    /**
     * 实体映射数据库表名字 BizCardTemplate
     */
    const BIZ_CARD_TEMPLATE = 'BizCardTemplate';
    /**
     * 实体映射数据库表名字 BizOperator
     */
    const BIZ_OPERATOR = 'BizOperator';
    /**
     * 实体映射数据库表名字 BizOperatorExtendInfo
     */
    const BIZ_OPERATOR_EXTEND_INFO = 'BizOperatorExtendInfo';
    /**
     * 实体映射数据库表名字 CalendarEvent
     */
    const CALENDAR_EVENT = 'CalendarEvent';
    /**
     * 实体映射数据库表名字 EventContactMap
     */
    const EVENTCONTACTMAP = 'EventContactMap';
    /**
     * 实体映射数据库表名字 CalendarNote
     */
    const CALENDAR_NOTE = 'CalendarNote';
    /**
     * 实体映射数据库表名字 CardTemplate
     */
    const CARD_TEMPLATE = 'CardTemplate';
    /**
     * 实体映射数据库表名字 Guild
     */
    const GUILD = 'Guild';
    /**
     * 实体映射数据库表名字 GuildCard
     */
    const GUILD_CARD = 'GuildCard';
    /**
     * 实体映射数据库表名字 GuildMember
     */
    const GUILD_MEMBER = 'GuildMember';

    /*hr entity*/
    /**
     * 实体映射数据库表名字 HrDepartment
     */
    const HR_DEPARTMENT = 'HrDepartment';
    /**
     * 实体映射数据库表名字 HrRecruiter
     */
    const HR_RECRUITER = 'HrRecruiter';
    /**
     * 实体映射数据库表名字 HrJobCategory
     */
    const HR_JOB_CATEGORY = 'HrJobCategory';
    /**
     * 实体映射数据库表名字 HrJobs
     */
    const HR_JOBS = 'HrJobs';
    /**
     * 实体映射数据库表名字 HrJobProperties
     */
    const HR_JOB_PROPERTIES = 'HrJobProperties';

    /**
     * 实体映射数据库表名字 HrCandidateSetting
     */
    const HR_CANDIDATE_SETTING = 'HrCandidateSetting';

    /**
     * 实体映射数据库表名字 HrCandidateSpecial
     */
    const HR_CANDIDATE_SPECIAL = 'HrCandidateSpecial';
    /**
     * 实体映射数据库表名字 HrFavoriteCandidate
     */
    const HR_FAVORITE_CANDIDATE = 'HrFavoriteCandidate';

    /**
     * 实体映射数据库表名字 HrFavoriteJobs
     */
    const HR_FAVORITE_JOBS = 'HrFavoriteJobs';

    /**
     * 实体映射数据库表名字 HrCandidate
     */
    const HR_CANDIDATE = 'HrCandidate';

    /**
     * 实体映射数据库表名字 HrCandidateExperience
     */
    const HR_CANDIDATE_EXPERIENCE = 'HrCandidateExperience';
    /**
     * 实体映射数据库表名字 HrCandidateEducation
     */
    const HR_CANDIDATE_EDUCATION = 'HrCandidateEducation';
    /**
     * 实体映射数据库表名字 HrCandidateObjective
     */
    const HR_CANDIDATE_OBJECTIVE = 'HrCandidateObjective';

    /**
     * 实体映射数据库表名字 HrJobApply
     */
    const HR_JOB_APPLY = 'HrJobApply';
    /**
     * 实体映射数据库表名字 HrCandidateFollows
     */
    const HR_CANDIDATE_FOLOWS = 'HrCandidateFollows';
    /**
     * 实体映射数据库表名字 HrVisitedLog
     */
    const HR_VISITED_LOG = 'HrVisitedLog';
    
    /**
     * 实体映射数据库表名字 HrCandidateAward
     */
    const HR_CANDIDATE_AWARD = 'HrCandidateAward';
    
    /**
     * 实体映射数据库表名字 HrCandidateLanguage
     */
    const HR_CANDIDATE_LANGUAGE = 'HrCandidateLanguage';
    
    /**
     * 实体映射数据库表名字 HrCandidateSkill
     */
    const HR_CANDIDATE_SKILL = 'HrCandidateSkill';
    
    /**
     * 实体映射数据库表名字 HrCandidateTesting
     */
    const HR_CANDIDATE_TESTING = 'HrCandidateTesting';

    /**
     * 实体映射数据库表名字 HrCandidateUnion
     */
    const HR_CANDIDATE_UNION = 'HrCandidateUnion';

    /**
     * 实体映射数据库表名字 HrCandidateWorks
     */
    const HR_CANDIDATE_WORKS = 'HrCandidateWorks';

    /**
     * 实体映射数据库表名字 HrCandidatePatent
     */
    const HR_CANDIDATE_PATENT = 'HrCandidatePatent';

    /**
     * 实体映射数据库表名字 HrCandidateCertification
     */
    const HR_CANDIDATE_CERTIFICATION = 'HrCandidateCertification';

    /**
     * 实体映射数据库表名字 HrCandidatePublishment
     */
    const HR_CANDIDATE_PUBLISHMENT = 'HrCandidatePublishment';

    /**
     * 实体映射数据库表名字 LoginSession
     */
    const LOGIN_SESSION = 'LoginSession';
    /**
     * 实体映射数据库表名字 SysCardTemplate
     */
    const SYS_CARD_TEMPLATE = 'SysCardTemplate';
    /**
     * 实体映射数据库表名字 Topic
     */
    const TOPIC = 'Topic';
    /**
     * 实体映射数据库表名字 TopicCategory
     */
    const TOPIC_CATEGORY = 'TopicCategory';
    /**
     * 实体映射数据库表名字 TopicComment
     */
    const TOPIC_COMMENT = 'TopicComment';
    /**
     * 实体映射数据库表名字 TopicHot
     */
    const TOPIC_HOT = 'TopicHot';
    /**
     * 实体映射数据库表名字 TopicTop
     */
    const TOPIC_TOP = 'TopicTop';

    /**
     * 实体映射数据库表名字 EmailMessage
     */
    const EMAIL_MESSAGE = 'EmailMessage';

    /**
     * 实体映射数据库表名字 Message
     */
    const MESSAGE = 'Message';
    
    /**
     * 实体映射数据库表名字 SnsTags
     */
    const SNS_TAGS = 'SnsTags';
    /**
     * 实体映射数据库表名字 SnsAccount
     */
    const SNS_ACCOUNT = 'SnsAccount';
    /**
     * 实体映射数据库表名字 SnsNews
     */
    const SNS_MAXIMS = 'SnsNews';
    /**
     * 实体映射数据库表名字 SnsNewsComment
     */
    const SNS_MAXIMS_COMMENT = 'SnsNewsComment';
    /**
     * 实体映射数据库表名字 SnsTrendsPermission
     */
    const SNS_TRENDS_PERMISSION = 'SnsTrendsPermission';
    /**
     * 实体映射数据库表名字 SnsTrendsComment
     */
    const SNS_TRENDS_COMMENT = 'SnsTrendsComment';
	/**
     * 实体映射数据库表名字 SnsMention
     */
    const SNS_MENTION = 'SnsMention';
    /**
     * 实体映射数据库表名字 SnsMentionComment
     */
    const SNS_MENTION_COMMENT = 'SnsMentionComment';

    /**
     * 实体映射数据库表名字 SnsMaximComment
     */
    const SNS_CONTENT_SHARING = 'SnsContentSharing';
    /**
     * 实体映射数据库表名字 SnsMaximComment
     */
    const SNS_CONTENT_COMMENT = 'SnsContentComment';
    /**
     * 实体映射数据库表名字 SnsTalk
     */
    const SNS_TALK = 'SnsTalk';
    
    /**
     * 实体映射数据库表名字 SnsTrends
     */
    const SNS_TRENDS = 'SnsTrends';

    /**
     * 实体映射数据库表名字 SnsActivity
     */
    const SNS_ACTIVITY = 'SnsActivity';
    /**
     * 实体映射数据库表名字 SnsActivityComment
     */
    const SNS_ACTIVITY_COMMENT = 'SnsActivityComment';
    /**
     * 实体映射数据库表名字 SnsActivityFollows
     */
    const SNS_ACTIVITY_FOLLOWS = 'SnsActivityFollows';
    /**
     * 实体映射数据库表名字 SnsActivityResource
     */
    const SNS_ACTIVITY_RESOURCE = 'SnsActivityResource';
    /**
     * 实体映射数据库表名字 SnsGroup
     */
    const SNS_GROUP = 'SnsGroup';
    /**
     * 实体映射数据库表名字 SnsGroupNotice
     */
    const SNS_GROUP_NOTICE = 'SnsGroupNotice';
    /**
     * 实体映射数据库表名字 SnsGroupMembers
     */
    const SNS_GROUP_MEMBERS = 'SnsGroupMembers';
    /**
     * 实体映射数据库表名字 SnsGroupTalk
     */
    const SNS_GROUP_TALK = 'SnsGroupTalk';
    /**
     * 实体映射数据库表名字 SnsGroupJionRequest
     */
    const SNS_GROUP_JION_REQUEST = 'SnsGroupJionRequest';
    /**
     * 实体映射数据库表名字 SnsGroupCategory
     */
    const SNS_GROUP_CATEGORY = 'SnsGroupCategory';
    /**
     * 实体映射数据库表名字 SnsGroupCategoryMap
     */
    const SNS_GROUP_CATEGORY_MAP = 'SnsGroupCategoryMap';
    /**
     * 实体映射数据库表名字 PushToken
     */
    const PUSH_TOKEN = 'PushToken';
    /**
     *  实体映射数据库表名字 Feedback
     */
    const FEED_BACK  =   'Feedback';
    /**
     * 默认查询列 AccountBiz
     */
    const FIELDS_ACCOUNTBIZ = 'bizid,bizname,bizemail,bizaddress,bizlicense,bizcode,logo';
    /**
     * 默认查询列 BizOperator
     */
    const FIELDS_BIZOPERATOR = 'name,personalid,mobile,email,idcardcopy,authcopy';
    /**
     * 默认查询列 BizCard
     */
    const FIELDS_BIZCARD = 'vcardid,state';
    /**
     * 默认查询列 BizCardGroup
     */
    const FIELDS_BIZCARDGROUP = 'groupid,group';
    /**
     * 默认查询列 BizCardApplyInfo
     */
    const FIELDS_BIZCARDAPPLYINFO = 'vcardid,verifycode,name,email,mobile,date,state';
    /**
     * 默认查询列 CalendarEvent
     */
    const FIELDS_CALENDAREVENT = 'eventid,accountid,title,type,starttime,endtime,timezone,repeating,rendtime,remindtime,content,contactid,isinviter';
    /**
     * 默认查询列 CalendarNote
     */
    const FIELDS_CALENDARNOTE = 'noteid,title,starttime,content,contactid,vcardid';
    /**
     * 默认查询列 Guild
     */
    const FIELDS_GUILD = 'guildid,name,content,remark';
    /**
     * 默认查询列 GuildMember
     */
    const FIELDS_GUILDMEMBER = 'guildid,memberid,name,remark';
    /**
     * 默认查询列 GuildVcard
     */
    const FIELDS_GUILDVCARD = 'vcardid,message,type,creatdate';
    /**
     * 默认查询列 Topic
     */
    const FIELDS_TOPIC = 'topicid,title,content,creatdate';
    /**
     * 默认查询列 SnsTrends 列表
     */
    const FIELDS_SNS_TRENDS = 'trendsid,clientid,content,datetime';
    /**
     * 默认查询列 TopicComment
     */
    const FIELDS_TOPICCOMMENT = 'commentid,comment';
    /**
     * 默认查询列 TopicCategory
     */
    const FIELDS_TOPICCATEGORY = 'categoryid,name,description,createdate';
    /**
     *
     * @var 当前用户缓存键名
     */
    const CACHE_KEY_USER_SELF = 'userid_self';
}
