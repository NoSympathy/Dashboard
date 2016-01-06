Public Class PVP

    Private _pvp_rank As Integer
    Private _aggregate As PvpStats
    Private _professions As PvpProfessions
    Private _ladders As PvpLadder

    Public Property pvp_rank() As Integer
        Get
            Return Me._pvp_rank
        End Get
        Set(value As Integer)
            Me._pvp_rank = value
        End Set
    End Property

    Public Property aggregate() As PvpStats
        Get
            Return Me._aggregate
        End Get
        Set(value As PvpStats)
            Me._aggregate = value
        End Set
    End Property

    Public Property professions() As PvpProfessions
        Get
            Return Me._professions
        End Get
        Set(value As PvpProfessions)
            Me._professions = value
        End Set
    End Property

    Public Property ladders() As PvpLadder
        Get
            Return Me._ladders
        End Get
        Set(value As PvpLadder)
            Me._ladders = value
        End Set
    End Property


    'Public Sub New(pvp_rank As Integer, aggregate As String, professions As String, ladders As String)
    '    Me.pvp_rank = pvp_rank
    '    Me.aggregate = aggregate
    '    Me.professions = professions
    '    Me.ladders = ladders
    'End Sub

End Class

Public Class PvpProfessions
    Private _elementalist As PvpStats
    Private _guardian As PvpStats
    Private _warior As PvpStats
    Private _mesmer As PvpStats
    Private _ranger As PvpStats
    Private _necromancer As PvpStats
    Private _engineer As PvpStats
    Private _revenant As PvpStats
    Private _thief As PvpStats

    Private Property elementalist() As PvpStats
        Get
            Return _elementalist
        End Get
        Set(value As PvpStats)
            _elementalist = value
        End Set
    End Property
    Private Property guardian() As PvpStats
        Get
            Return _guardian
        End Get
        Set(value As PvpStats)
            _guardian = value
        End Set
    End Property
    Private Property warior() As PvpStats
        Get
            Return _warior
        End Get
        Set(value As PvpStats)
            _warior = value
        End Set
    End Property
    Private Property mesmer() As PvpStats
        Get
            Return _mesmer
        End Get
        Set(value As PvpStats)
            _mesmer = value
        End Set
    End Property
    Private Property ranger() As PvpStats
        Get
            Return _ranger
        End Get
        Set(value As PvpStats)
            _ranger = value
        End Set
    End Property
    Private Property necromancer() As PvpStats
        Get
            Return _necromancer
        End Get
        Set(value As PvpStats)
            _necromancer = value
        End Set
    End Property
    Private Property engineer() As PvpStats
        Get
            Return _engineer
        End Get
        Set(value As PvpStats)
            _engineer = value
        End Set
    End Property
    Private Property revenant() As PvpStats
        Get
            Return _revenant
        End Get
        Set(value As PvpStats)
            _revenant = value
        End Set
    End Property
    Private Property thief() As PvpStats
        Get
            Return _thief
        End Get
        Set(value As PvpStats)
            _thief = value
        End Set
    End Property
End Class

Public Class PvpLadder
    Private _ranked As PvpStats
    Private _unranked As PvpStats

    Public Property ranked() As PvpStats
        Get
            Return _ranked
        End Get
        Set(value As PvpStats)
            _ranked = value
        End Set
    End Property
    Public Property unranked() As PvpStats
        Get
            Return _unranked
        End Get
        Set(value As PvpStats)
            _unranked = value
        End Set
    End Property

End Class

Public Class PvpStats
    Private _wins As Integer
    Private _losses As Integer
    Private _desertions As Integer
    Private _byes As Integer
    Private _forfeits As Integer

    Public Property wins() As Integer
        Get
            Return _wins
        End Get
        Set(value As Integer)
            _wins = value
        End Set
    End Property
    Public Property losses() As Integer
        Get
            Return _losses
        End Get
        Set(value As Integer)
            _losses = value
        End Set
    End Property
    Public Property desertions() As Integer
        Get
            Return _desertions
        End Get
        Set(value As Integer)
            _desertions = value
        End Set
    End Property
    Public Property byes() As Integer
        Get
            Return _byes
        End Get
        Set(value As Integer)
            _byes = value
        End Set
    End Property

    Public Property forfeits() As Integer
        Get
            Return _forfeits
        End Get
        Set(value As Integer)
            _forfeits = value
        End Set
    End Property
End Class
