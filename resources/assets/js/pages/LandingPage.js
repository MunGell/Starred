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
                        <div className="page-landing__feature-icon">
                            <a href="/sync"><Glyph icon="repo-sync" /></a>
                        </div>
                        <h3 className="page-landing__feature-description">
                            Sync your starred repositories
                        </h3>
                    </div>
                    <div className="page-landing__feature">
                        <div className="page-landing__feature-icon">
                            <a href="/#/repositories"><Glyph icon="tag" /></a>
                        </div>
                        <h3 className="page-landing__feature-description">
                            Categorise repositories with tags
                        </h3>
                    </div>
                    <div className="page-landing__feature">
                        <div className="page-landing__feature-icon">
                            <a href="/#/search"><Glyph icon="search" /></a>
                        </div>
                        <h3 className="page-landing__feature-description">
                            Find your starred repositories
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
