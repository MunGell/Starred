import React from 'react'

import Glyph from 'elemental/lib/components/Glyph'

export default React.createClass({

    getDefaultProps: function () {
        return {}
    },

    getInitialState: function () {
        return {}
    },

    render: function () {
        return (
            <div className="page-landing">
                <div className="page-landing__title">
                    <h1>Starred by me</h1>
                    <h2>GitHub Repositories. Organised.</h2>
                </div>
                <div className="page-landing__features">
                    <div className="page-landing__feature">
                        <a href="/sync">
                            <div className="page-landing__feature-icon">
                                <Glyph icon="repo-sync" />
                            </div>
                        </a>
                        <h3 className="page-landing__feature-description">
                            Sync
                        </h3>
                    </div>
                    <div className="page-landing__feature">
                        <a href="/#/repositories">
                            <div className="page-landing__feature-icon">
                                <Glyph icon="tag" />
                            </div>
                        </a>
                        <h3 className="page-landing__feature-description">
                            Tag
                        </h3>
                    </div>
                    <div className="page-landing__feature">
                        <a href="/#/search">
                            <div className="page-landing__feature-icon">
                                <Glyph icon="search" />
                            </div>
                        </a>
                        <h3 className="page-landing__feature-description">
                            Find
                        </h3>
                    </div>
                </div>
                <div className="page-landing__cta">
                    <a href="/auth/login" className="page-landing__login-button">Organise</a>
                </div>
            </div>
        )
    }

});
