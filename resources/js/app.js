import './bootstrap';

import './components/helpers/HelpersMask';

import {
    HelpersTheme,
    HelpersAction
} from './components/helpers';

HelpersAction({
    lineView: true,
    lineDelete: true,
    formLogin: true,
    formUser: true
});

HelpersTheme({
    pace: true,
    sideMenu: true,
    menuMinimize: true,
    radioAndCheckbox: true,
    checkbox: true,
    mask: true
});