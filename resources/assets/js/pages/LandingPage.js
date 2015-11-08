import React from 'react'
import Style from 'react-postcss'
import Glyph from 'elemental/lib/components/Glyph'

import postcssPlugins from '../postcss-plugins'

export default React.createClass({

    render: function () {
        return (
            <div className="page-landing">
                <Style plugins={postcssPlugins}>
                    {this.style()}
                </Style>
                <div className="page-landing__title">
                    <h1>Starred by me</h1>
                    <h2>GitHub Repositories. Organised.</h2>
                </div>
                <div className="page-landing__features">
                    <div className="page-landing__feature">
                        <a href="/sync">
                            <h3 className="page-landing__feature-title">
                                <Glyph icon="repo-sync" /> Sync
                            </h3>
                        </a>
                        <p className="page-landing__feature-description">
                            Synchronise stars from your account on GitHub
                        </p>
                    </div>
                    <div className="page-landing__feature">
                        <a href="/#/repositories">
                            <h3 className="page-landing__feature-title">
                                <Glyph icon="tag" /> Tag
                            </h3>
                        </a>
                        <p className="page-landing__feature-description">
                            Categorise repositories using&nbsp;tags
                        </p>
                    </div>
                    <div className="page-landing__feature">
                        <a href="/#/search">
                            <h3 className="page-landing__feature-title">
                                <Glyph icon="search" /> Search
                            </h3>
                        </a>
                        <p className="page-landing__feature-description">
                            Find repositories by name, author, description or&nbps;tag
                        </p>
                    </div>
                </div>
                <div className="page-landing__cta">
                    <a href="/auth/login" className="page-landing__login-button">Login with GitHub</a>
                </div>
            </div>
        )
    },

    style: function() {
        return `
            .page-landing {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                height: 100%;
                width: 100%;
                overflow: hidden;
                background: #0E0C18 url(img/bg.jpg) no-repeat;
                background-size: cover;

                &__title {
                    text-align: center;

                    h1 {
                        margin: 0 0 10px 0;
                        color: #fff;
                        font-size: 42px;
                    }

                    h2 {
                        color: rgba(255, 255, 255, 0.75);
                        font-size: 18px;
                    }
                }

                &__features {
                    display: flex;
                    justify-content: space-between;
                    width: 80%;
                    max-width: 800px;
                    margin: 25px 0;
                }

                &__feature {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    width: 30%;
                    border: solid 1px rgba(255, 255, 255, 0.5);
                    border-radius: 4px;
                    transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;

                    &:hover {
                        background-color: rgba(255, 255, 255, 0.125);
                    }

                    h3 {
                        padding: 10px;
                        margin: 0;
                        color: #fff;
                        text-align: center;
                    }

                    a, a:hover {
                        text-decoration: none;
                    }
                }

                &__feature-title {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    text-align: center;

                    .octicon {
                        color: #fff;
                        font-size: 42px;
                        margin-right: 10px;
                    }
                }

                &__feature-description {
                    margin-top: 0;
                    padding: 0 10%;
                    color: #fff;
                    text-align: center;
                }

                &__cta {
                    text-align: center;
                }

                &__login-button {
                    display: block;
                    padding: 10px 40px;
                    border: 1px solid #ffffff;
                    border-radius: 4px;
                    background: transparent;
                    color: #ffffff;
                    font-size: 16px;
                    text-transform: uppercase;
                    box-shadow: inset 0 0 0 1px #ffffff;
                    transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
                    text-decoration: none;

                    &:hover {
                        background-color: rgba(255, 255, 255, 0.125);
                        color: #ffffff;
                        text-decoration: none;
                    }
                }
            }
        `
    }

});
