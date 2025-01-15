// src/composables/useIconResolver.js
import {
    DashboardOutlined,
    AuditOutlined,
    BookOutlined,
    ScheduleOutlined,
    FormOutlined,
    TrophyOutlined,
    CalendarOutlined,
    UserOutlined,
    FolderOpenOutlined,
    HomeOutlined,
    GlobalOutlined,
    SettingOutlined,
    FieldTimeOutlined,
    ClockCircleOutlined,
    EnvironmentOutlined,
    CarOutlined,

} from "@ant-design/icons-vue";

export function useIconResolver() {
    function resolveIcon(iconName) {
        const iconsMap = {
            DashboardOutlined,
            AuditOutlined,
            BookOutlined,
            ScheduleOutlined,
            FormOutlined,
            TrophyOutlined,
            CalendarOutlined,
            UserOutlined,
            FolderOpenOutlined,
            HomeOutlined,
            GlobalOutlined,
            FieldTimeOutlined,
            SettingOutlined,
            ClockCircleOutlined,
            EnvironmentOutlined,
            CarOutlined
        };
        return iconsMap[iconName] || null;
    }

    return {
        resolveIcon,
    };
}
